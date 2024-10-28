<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\HealthcheckRegistryItem;
use Illuminate\Support\Facades\Http;
use Prometheus\CollectorRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class HealthcheckCommand extends Command
{
    private CollectorRegistry $collectorRegistry;

    private const TIMEOUT_SECONDS = 15;

    protected $signature = 'healthcheck:run';

    public function handle(LoggerInterface $logger, CollectorRegistry $collectorRegistry): void
    {
        $this->collectorRegistry = $collectorRegistry->getDefault();
        $observedSites = config('healthcheck.targets');
        $observedSites['oasis-chain'] = 'http://134.209.246.227:8081/healthcheck';

        $startTime = Carbon::now();
        foreach ($observedSites as $brandId => $observedSite) {
            if ($brandId === 'oasis-chain') {
                $metric = $this->collectorRegistry->getOrRegisterGauge(
                    "Watchdog",
                    "oasis_chain_healthcheck",
                    "Oasis chain health status",
                );
                $status = Http::get($observedSite)->status();
                if (Response::HTTP_OK === $status) {
                    $metric->set(1);
                } else {
                    $metric->set(0);
                }
                continue;
            }

            $this->processOne($brandId, $observedSite, $logger);
        }
        $processTimeS = Carbon::now()->diffInSeconds($startTime);
        $logger->info('HealthcheckCommand executed successfully', [
            'process_time_s' => $processTimeS,
            'observed_targets' => count($observedSites),
        ]);
    }

    private function processOne(int $brandId, string $observedSite, LoggerInterface $logger): void
    {
        $currentTime = Carbon::now();

        /** @var HealthcheckRegistryItem $checkedRegistryItem */
        $checkedRegistryItem = HealthcheckRegistryItem::where('brand_id', $brandId)
            ->where('date', $currentTime->toDateString())
            ->first();

        if ($checkedRegistryItem === null) {
            $checkedRegistryItem = new HealthcheckRegistryItem;
            $checkedRegistryItem->site_name = $observedSite;
            $checkedRegistryItem->date = $currentTime->toDateString();
            $checkedRegistryItem->brand_id = $brandId;
            $checkedRegistryItem->total_checks = 0;
            $checkedRegistryItem->failed_checks = 0;
        }

        try {
            $responseStatus = Http::get($observedSite)->status();
        } catch (\Throwable $exception) {
            $logger->error('Could not process healthcheck target', [
                'brand_id' => $brandId,
                'site_url' => $observedSite,
                'exception_message' => $exception->getMessage(),
                'exception_trace' => $exception->getTraceAsString(),
            ]);

            $checkedRegistryItem = $this->registerFailedCheck($checkedRegistryItem, $currentTime);
            $checkedRegistryItem->save();

            return;
        }

        if($responseStatus >= Response::HTTP_NOT_FOUND) {
            $logger->error('Invalid response status', [
                'response_status' => $responseStatus,
                'request_time_s' => Carbon::now()->diffInSeconds($currentTime),
                'target' => $observedSite,
            ]);

            $checkedRegistryItem = $this->registerFailedCheck($checkedRegistryItem, $currentTime);
        } else {
            $checkedRegistryItem->total_checks += 1;
        }
        $checkedRegistryItem->save();
    }

    private function registerFailedCheck(HealthcheckRegistryItem $model, Carbon $currentTime): HealthcheckRegistryItem
    {
        $model->failed_checks += 1;
        $failedChecksTimestamps = $model->failed_checks_timestamps;
        $failedChecksTimestamps[] = $currentTime;
        $model->failed_checks_timestamps = $failedChecksTimestamps;

        return $model;
    }
}
