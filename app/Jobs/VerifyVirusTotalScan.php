<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exceptions\VirusTotal\MalwareDetectedException;
use App\Exceptions\VirusTotal\ScanVerificationFailedException;
use App\External\Slack\Client\Client as SlackClient;
use App\External\VirusTotal\Client\Client as VirusTotalClient;
use App\Infrastructure\QueueEnum;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimitedWithRedis;
use Illuminate\Support\DateFactory;
use Psr\Log\LoggerInterface;
use Throwable;

class VerifyVirusTotalScan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(
        private readonly string $analysisReportId,
    ) {
    }

    public function middleware(): array
    {
        return [(new RateLimitedWithRedis(QueueEnum::VIRUS_TOTAL_SCAN->value))];
    }

    /**
     * @throws ScanVerificationFailedException
     */
    public function handle(
        VirusTotalClient $virusTotalClient,
        Dispatcher $dispatcher,
        LoggerInterface $logger,
        DateFactory $dateFactory,
        SlackClient $slackClient,
    ): void {
        try {
            $responseArray = $virusTotalClient->getUrlAnalysisReport($this->analysisReportId);

            if ('completed' !== $responseArray['data']['attributes']['status']) {
                $logger->debug(__CLASS__ . ': verification is still in progress', [
                    'analysisReportId' => $this->analysisReportId,
                ]);

                $dispatcher->dispatch((new self($this->analysisReportId))
                    ->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value)
                    ->delay($dateFactory->now()->addMinute()));

                return;
            }

            $stats = $responseArray['data']['attributes']['stats'];

            if ((int) $stats['malicious'] > 0 || (int) $stats['suspicious'] > 0) {
                $this->handleMalwareDetection($responseArray, $stats);
            }

            $logger->debug(__CLASS__ . ': all good.', [
                'analysisReportId' => $this->analysisReportId,
                'website' => $responseArray['meta']['url_info']['url'],
                'stats' => $stats,
            ]);
        } catch (MalwareDetectedException $exception) {
            $logger->error(__CLASS__ . ':' . $exception->getMessage(), [
                'analysisReportId' => $this->analysisReportId,
                'trace' => $exception->getTrace(),
            ]);

            $slackClient->sendMessage($exception->toSlack());

            return;
        } catch (Throwable $exception) {
            throw new ScanVerificationFailedException(
                message: 'Scan verification failed for analysis report: ' . $this->analysisReportId,
                previous: $exception,
            );
        }
    }

    /**
     * @throws MalwareDetectedException
     */
    private function handleMalwareDetection(array $responseArray, array $stats): void
    {
        $websiteUrl = $responseArray['meta']['url_info']['url'];
        $parsedUrl = parse_url($websiteUrl);
        $domain = $parsedUrl['host'] ?? '';
        $reportUrl = 'https://www.virustotal.com/gui/domain/' . $domain;

        $messagePrefix = (int) $stats['malicious'] > 0 ? 'Malicious' : 'Suspicious';
        $slackMessage = '<!channel> ' . $messagePrefix . ' software detected for ' . $websiteUrl . PHP_EOL .
            'Please check the following report: <' . $reportUrl . '|View Report>';

        throw new MalwareDetectedException(
            message: "$messagePrefix software detected in the report: " . $this->analysisReportId,
            slackMessage: $slackMessage
        );
    }
}
