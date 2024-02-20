<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\HealthcheckRegistryItem;
use Illuminate\Support\Facades\Http;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class HealthcheckCommand extends Command
{
    protected $signature = 'healthcheck:run';

    public function handle(LoggerInterface $logger)
    {
        $observedSites = config('healthcheck.targets');

        foreach ($observedSites as $brandId => $observedSite) {
            try {
                $this->processOne($brandId, $observedSite, $logger);
            } catch (\Throwable $exception) {
                $logger->error('Could not process healthcheck target', [
                    'brand_id' => $brandId,
                    'site_url' => $observedSite,
                    'exception_message' => $exception->getMessage(),
                    'exception_trace' => $exception->getTraceAsString(),
                ]);
            }
        }
    }

    private function processOne(int $brandId, string $observedSite, LoggerInterface $logger): void
    {
        $responseStatus = Http::timeout(4)->get($observedSite)->status();

        $currentTime = Carbon::now();

        /** @var HealthcheckRegistryItem $checkedRegistryItem */
        $checkedRegistryItem = HealthcheckRegistryItem::where('brand_id', $brandId)
            ->where('date', $currentTime->toDateString())
            ->first();

        if ($checkedRegistryItem === null) {
            $item = new HealthcheckRegistryItem;
            $item->site_name = $observedSite;
            $item->date = $currentTime->toDateString();
            $item->brand_id = $brandId;
            $item->total_checks = 1;
            $item->failed_checks = 0;

            if($responseStatus !== Response::HTTP_OK) {
                $item = $this->registerFailedCheck($item, $currentTime);
            }

            $item->save();

            continue;
        }


        $checkedRegistryItem->total_checks += 1;

        if($responseStatus >= Response::HTTP_BAD_REQUEST) {
            $checkedRegistryItem = $this->registerFailedCheck($checkedRegistryItem, $currentTime);
            $logger->error('healthcheck request failed', [
                'response_status' => $responseStatus,
                'target' => $observedSite,
            ]);
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
