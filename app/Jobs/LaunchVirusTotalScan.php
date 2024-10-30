<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exceptions\VirusTotal\ScanLaunchFailedException;
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

class LaunchVirusTotalScan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private const BATCH_SIZE = 4;

    public function __construct(
        private readonly array $websites,
        private readonly array $analysisReportIds = []
    ) {
    }

    public function middleware(): array
    {
        return [(new RateLimitedWithRedis(QueueEnum::VIRUS_TOTAL_SCAN->value))];
    }

    /**
     * @throws ScanLaunchFailedException
     */
    public function handle(
        VirusTotalClient $virusTotalClient,
        Dispatcher $dispatcher,
        DateFactory $dateFactory,
        LoggerInterface $logger,
    ): void {
        try {
            $logger->info(__CLASS__ . ': Launching VirusTotal scan for websites', [
                'websites' => $this->websites,
            ]);

            $websitesToProcess = array_slice($this->websites, 0, self::BATCH_SIZE);
            $remainingWebsites = array_slice($this->websites, self::BATCH_SIZE);

            $newAnalysisReportIds = [];

            foreach ($websitesToProcess as $websiteUrl) {
                $logger->debug(__CLASS__ . ': Scanning website', compact('websiteUrl'));

                try {
                    $newAnalysisReportIds[] = $virusTotalClient->scanUrl($websiteUrl);
                } catch (Throwable $e) {
                    $logger->error(__CLASS__ . ': Failed to scan website', [
                        'website_url' => $websiteUrl,
                        'exception_message' => $e->getMessage(),
                        'exception_trace' => $e->getTraceAsString(),
                    ]);
                }
            }

            $allAnalysisReportIds = array_merge($this->analysisReportIds, $newAnalysisReportIds);

            $logger->debug(__CLASS__ . ': Collected analysis report IDs',
                compact('newAnalysisReportIds', 'allAnalysisReportIds')
            );

            if (!empty($remainingWebsites)) {
                $logger->info(__CLASS__ . ': Scheduling next batch for remaining websites',
                    compact('remainingWebsites')
                );

                $dispatcher->dispatch((new self($remainingWebsites, $allAnalysisReportIds))
                    ->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value)
                    ->delay($dateFactory->now()->addMinute()));
            } else {
                $logger->info(__CLASS__ . ': All websites processed. Dispatching VerifyVirusTotalScan job',
                    compact('allAnalysisReportIds')
                );

                $dispatcher->dispatch((new VerifyVirusTotalScan($allAnalysisReportIds))
                    ->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value)
                    ->delay($dateFactory->now()->addMinute()));
            }
        } catch (Throwable $exception) {
            $logger->error(__CLASS__ . ': Exception occurred during the job execution.', [
                'error_message' => $exception->getMessage(),
                'error_trace' => $exception->getTraceAsString(),
            ]);

            throw new ScanLaunchFailedException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
