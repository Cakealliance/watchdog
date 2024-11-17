<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exceptions\Contracts\ReportableToSlackInterface;
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
use LogicException;
use Psr\Log\LoggerInterface;
use Throwable;

class VerifyVirusTotalScan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private const STATUS_COMPLETED = 'completed';
    private const BATCH_SIZE = 4;

    public function __construct(
        private readonly array $analysisReportIds,
        private readonly array $queuedAnalysisReportIds = [],
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
            $logger->info(__CLASS__ . ': Starting verification of VirusTotal scans', [
                'analysis_report_ids' => $this->analysisReportIds,
            ]);

            $reportsToProcess = array_slice($this->analysisReportIds, 0, self::BATCH_SIZE);
            $remainingReports = array_slice($this->analysisReportIds, self::BATCH_SIZE);
            $queuedReports = $this->queuedAnalysisReportIds;

            foreach ($reportsToProcess as $analysisReportId) {
                try {
                    $logger->debug(__CLASS__ . ': Fetching analysis report', compact('analysisReportId'));

                    $responseArray = $virusTotalClient->getUrlAnalysisReport($analysisReportId);

                    if (self::STATUS_COMPLETED !== $responseArray['data']['attributes']['status']) {
                        if (in_array($analysisReportId, $this->queuedAnalysisReportIds, true)) {
                            throw new LogicException('Retry attempt to verify scan failed. ID: ' . $analysisReportId);
                        }

                        $remainingReports[] = $analysisReportId;
                        $queuedReports[] = $analysisReportId;
                        $logger->debug(__CLASS__ . ': Verification is still incomplete.',
                            compact('analysisReportId'));

                        continue;
                    }

                    $stats = $responseArray['data']['attributes']['stats'];

                    if ((int) $stats['malicious'] > 0 || (int) $stats['suspicious'] > 0) {
                        $this->handleMalwareDetection($responseArray, $stats);
                    }

                    $logger->debug(__CLASS__ . ': Report completed without issues.', [
                        'analysis_report_id' => $analysisReportId,
                        'website' => $responseArray['meta']['url_info']['url'],
                        'stats' => $stats,
                    ]);
                } catch (Throwable $exception) {
                    if ($exception instanceof ReportableToSlackInterface) {
                        try {
                            $slackClient->sendMessage($exception->toSlack());
                        } catch (Throwable $slackException) {
                            $logger->error(__CLASS__ . ': Failed to send Slack notification', [
                                'error_message' => $slackException->getMessage(),
                                'error_trace' => $slackException->getTrace(),
                                'analysis_report_id' => $analysisReportId,
                            ]);
                        }
                    }

                    if ($exception instanceof MalwareDetectedException) {
                        $logger->warning(__CLASS__ . ': Malware detected for the website', [
                            'website_url' => $exception->getWebsiteUrl(),
                            'analysis_report_id' => $analysisReportId,
                            'error_message' => $exception->getMessage(),
                            'error_trace' => $exception->getTraceAsString(),
                        ]);

                        continue;
                    }

                    $logger->error(__CLASS__ . ': Exception occurred during scan verification', [
                        'error_message' => $exception->getMessage(),
                        'error_trace' => $exception->getTraceAsString(),
                        'analysis_report_id' => $analysisReportId,
                    ]);

                    continue;
                }
            }

            if (!empty($remainingReports)) {
                $logger->info(__CLASS__ . ': Dispatching verification for pending reports',
                    compact('remainingReports'));

                $dispatcher->dispatch((new self($remainingReports, $queuedReports))
                    ->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value)
                    ->delay($dateFactory->now()->addMinute()));
            } else {
                $logger->info(__CLASS__ . ': All reports processed successfully, no remaining reports.');
            }
        } catch (Throwable $exception) {
            $logger->error(__CLASS__ . ': Exception occurred during the job execution.', [
                'error_message' => $exception->getMessage(),
                'error_trace' => $exception->getTraceAsString(),
            ]);

            throw new ScanVerificationFailedException($exception->getMessage(), $exception->getCode(), $exception);
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
        $slackMessage = $messagePrefix . ' software detected for ' . $websiteUrl . PHP_EOL .
            'Please check the following report: <' . $reportUrl . '|View Report>';

        throw new MalwareDetectedException(
            websiteUrl: $websiteUrl,
            message: "$messagePrefix software detected in the report: " . $responseArray['data']['id'],
            slackMessage: $slackMessage
        );
    }
}
