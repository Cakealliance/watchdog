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
use Throwable;

class LaunchVirusTotalScan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(
        private readonly string $websiteUrl,
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
    ): void {
        try {
            $analysisReportId = $virusTotalClient->scanUrl($this->websiteUrl);

            $dispatcher->dispatch(
                (new VerifyVirusTotalScan($analysisReportId))
                    ->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value)
                    ->delay($dateFactory->now()->addMinute())
            );
        } catch (Throwable $exception) {
            throw new ScanLaunchFailedException(
                message: 'Failed to start scan for: ' . $this->websiteUrl,
                previous: $exception,
            );
        }
    }
}
