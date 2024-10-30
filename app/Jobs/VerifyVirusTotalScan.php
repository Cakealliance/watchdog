<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exceptions\VirusTotal\MalwareDetectedException;
use App\Exceptions\VirusTotal\ScanVerificationFailedException;
use App\External\Slack\Client\Client as SlackClient;
use App\External\VirusTotal\Client\Client as VirusTotalClient;
use App\Infrastructure\QueueEnum;
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

    private const STATUS_COMPLETED = 'completed';

    public function __construct(
        private readonly array $analysisReportIds,
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
        $pendingReports = [];

        $logger->info(__CLASS__ . ': Starting verification of VirusTotal scans', [
            'analysis_report_ids' => $this->analysisReportIds,
        ]);

        foreach ($this->analysisReportIds as $analysisReportId) {
            try {
                $logger->debug(__CLASS__ . ': Fetching analysis report', compact('analysisReportId'));

                $responseArray = $virusTotalClient->getUrlAnalysisReport($analysisReportId);

                if (self::STATUS_COMPLETED !== $responseArray['data']['attributes']['status']) {
                    $pendingReports[] = $analysisReportId;
                    $logger->debug(__CLASS__ . ': Verification is still in progress', compact('analysisReportId'));
                    continue;
                }

                $stats = $responseArray['data']['attributes']['stats'];

                if ((int) $stats['malicious'] > 0 || (int) $stats['suspicious'] > 0) {
                    $this->handleMalwareDetection($responseArray, $stats, $slackClient);
                }

                $logger->debug(__CLASS__ . ': Report completed without issues.', [
                    'analysis_report_id' => $analysisReportId,
                    'website' => $responseArray['meta']['url_info']['url'],
                    'stats' => $stats,
                ]);

            } catch (MalwareDetectedException $exception) {
                $logger->error(__CLASS__ . ': Malware detection exception occurred', [
                    'error_message' => $exception->getMessage(),
                    'error_trace' => $exception->getTraceAsString(),
                    'analysis_report_id' => $analysisReportId,
                ]);

                try {
                    $slackClient->sendMessage($exception->toSlack());

                    $logger->debug(__CLASS__ . ': Sent Slack notification for malware detection',
                        compact('analysisReportId')
                    );
                } catch (Throwable $slackException) {
                    $logger->error(__CLASS__ . ': Failed to send Slack notification', [
                        'error_message' => $slackException->getMessage(),
                        'error_trace' => $slackException->getTrace(),
                    ]);

                    throw new ScanVerificationFailedException(
                        message: 'Scan verification failed for analysis report: ' . $analysisReportId,
                        previous: $slackException,
                    );
                }
            } catch (Throwable $exception) {
                $logger->error(__CLASS__ . ': Unexpected exception occurred during scan verification', [
                    'error_message' => $exception->getMessage(),
                    'error_trace' => $exception->getTraceAsString(),
                    'analysis_report_id' => $analysisReportId,
                ]);

                throw new ScanVerificationFailedException(
                    message: 'Scan verification failed for analysis report: ' . $analysisReportId,
                    previous: $exception,
                );
            }
        }

        if (!empty($pendingReports)) {
            $logger->info(__CLASS__ . ': Dispatching verification for pending reports', compact('pendingReports'));

            $dispatcher->dispatch((new self($pendingReports))
                ->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value)
                ->delay($dateFactory->now()->addMinute()));
        } else {
            $logger->info(__CLASS__ . ': All reports processed successfully, no pending reports.');
        }
    }

    /**
     * @throws MalwareDetectedException
     */
    private function handleMalwareDetection(array $responseArray, array $stats, SlackClient $slackClient): void
    {
        $websiteUrl = $responseArray['meta']['url_info']['url'];
        $parsedUrl = parse_url($websiteUrl);
        $domain = $parsedUrl['host'] ?? '';
        $reportUrl = 'https://www.virustotal.com/gui/domain/' . $domain;

        $messagePrefix = (int) $stats['malicious'] > 0 ? 'Malicious' : 'Suspicious';
        $slackMessage = '<!channel> ' . $messagePrefix . ' software detected for ' . $websiteUrl . PHP_EOL .
            'Please check the following report: <' . $reportUrl . '|View Report>';

        throw new MalwareDetectedException(
            message: "$messagePrefix software detected in the report: " . $responseArray['data']['id'],
            slackMessage: $slackMessage
        );
    }
}
