<?php

declare(strict_types=1);

namespace App\Service\Metrics;

use App\Models\HealthcheckRegistryItem;

class LoadingTimeMetrics
{
    public function getAverageLoadingTime(HealthcheckRegistryItem $checkedRegistryItem): float
    {
        $loadingTimes = $checkedRegistryItem->loading_time;
        $loadingTimesValues = [];

        foreach ($loadingTimes as $loadingTime) {
            foreach ($loadingTime as $value) {
                $loadingTimesValues[] = $value;
            }
        }

        return (float)number_format(array_sum($loadingTimesValues)/count($loadingTimesValues), 2);;
    }

    public function getLoadingTimes(HealthcheckRegistryItem $checkedRegistryItem): array
    {
        $totalTodayLoadingTimes = [];

        foreach ($checkedRegistryItem->loading_time as $loading_times ) {
            foreach ($loading_times as $time => $loading_time) {
                $totalTodayLoadingTimes[] = [
                    'loading_time' => $loading_time,
                    'time' => $time,
                    'site_name' => $checkedRegistryItem->site_name,
                ];
            }
        }

        return $totalTodayLoadingTimes;
    }
}

