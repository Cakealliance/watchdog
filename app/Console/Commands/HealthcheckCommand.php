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
    private const TIMEOUT_SECONDS = 15;

    protected $signature = 'healthcheck:run';

    public function handle(LoggerInterface $logger)
    {
        $observedSites = config('healthcheck.targets');

        foreach ($observedSites as $brandId => $observedSite) {
            $this->processOne($brandId, $observedSite, $logger);
        }
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
            if ($brandId === 5) {
                $responseStatus = Http::timeout(self::TIMEOUT_SECONDS)
                    ->get("https://best-obmen.com/api/directions/USDTTRC20/P24UAH")
                    ->status();
            } else {
                $responseStatus = Http::timeout(self::TIMEOUT_SECONDS)->get($observedSite)->status();
            }
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
