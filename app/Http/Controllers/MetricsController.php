<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\HealthcheckRegistryItem;
use App\Service\Metrics\Enum\MetricName;
use App\Service\Metrics\LoadingTimeMetrics;
use Carbon\Carbon;
use Illuminate\Config\Repository;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

class MetricsController extends Controller
{
    public function index(
        Repository $config,
        LoadingTimeMetrics $loadingTimeMetrics,
    ) {
        $registry = new CollectorRegistry(new InMemory());

        $appName = $config->get('app.name');
        $observedSites = config('healthcheck.targets');
        $todayDate = Carbon::now()->toDateString();
        $yesterdayDate = Carbon::now()->subDay()->toDateString();

        foreach ($observedSites as $brandId => $observedSite) {

            $checkedRegistryItem = HealthcheckRegistryItem::where('brand_id', $brandId)
                ->where('date', $todayDate)
                ->first();

            $checksCount = $registry->registerGauge(
                $appName,
                MetricName::TODAY_CHECKS_LOADING_TIMES->value . $brandId,
                'today loading times count',
                ['site_name']
            );

            $checksCount->set($checkedRegistryItem->total_checks, [$checkedRegistryItem->site_name]);

            $failedChecksCount = $registry->registerGauge(
                $appName,
                MetricName::TODAY_FAILED_CHECKS_LOADING_TIMES->value . $brandId,
                'today failed loading times count',
                ['site_name']
            );

            $failedChecksCount->set($checkedRegistryItem->failed_checks, [$checkedRegistryItem->site_name]);


            $averageLoadingTime = $registry->registerGauge(
                $appName,
                MetricName::TODAY_AVERAGE_LOADING_TIME->value . $brandId,
                'today avg loading time',
                ['site_name']
            );

            $averageLoadingTime->set($loadingTimeMetrics->getAverageLoadingTime($checkedRegistryItem), [$checkedRegistryItem->site_name]);

            $todayLoadingTimes = $registry->registerCounter(
                $appName,
                MetricName::TODAY_LOADING_TIMES->value . $brandId,
                'Today loading times',
                ['time', 'site_name']
            );

            foreach ($loadingTimeMetrics->getLoadingTimes($checkedRegistryItem) as $row) {
                $todayLoadingTimes->incBy($row['loading_time'], [$row['time'], $row['site_name']]);
            }

            $yesterdayCheckedRegistryItem = HealthcheckRegistryItem::where('brand_id', $brandId)
                ->where('date', $yesterdayDate)
                ->first();

            $yesterdayChecksCount = $registry->registerGauge(
                $appName,
                MetricName::YESTERDAY_CHECKS_LOADING_TIMES->value . $brandId,
                'yesterday loading times count',
                ['site_name']
            );

            $yesterdayChecksCount->set($yesterdayCheckedRegistryItem->total_checks, [$yesterdayCheckedRegistryItem->site_name]);

            $yesterdayFailedChecksCount = $registry->registerGauge(
                $appName,
                MetricName::YESTERDAY_FAILED_CHECKS_LOADING_TIMES->value . $brandId,
                'yesterday failed loading times count',
                ['site_name']
            );

            $yesterdayFailedChecksCount->set($yesterdayCheckedRegistryItem->failed_checks, [$yesterdayCheckedRegistryItem->site_name]);

            $yesterdayAverageLoadingTime = $registry->registerGauge(
                $appName,
                MetricName::YESTERDAY_AVERAGE_LOADING_TIME->value . $brandId,
                'yesterday avg loading time',
                ['site_name']
            );

            $yesterdayAverageLoadingTime->set($loadingTimeMetrics->getAverageLoadingTime($yesterdayCheckedRegistryItem), [$yesterdayCheckedRegistryItem->site_name]);

            $yesterdayLoadingTimes = $registry->registerCounter(
                $appName,
                MetricName::YESTERDAY_LOADING_TIMES->value . $brandId,
                'Yesterday loading times',
                ['time', 'site_name']
            );

            foreach ($loadingTimeMetrics->getLoadingTimes($yesterdayCheckedRegistryItem) as $row) {
                $yesterdayLoadingTimes->incBy($row['loading_time'], [$row['time'], $row['site_name']]);
            }
        }

        $renderer = new RenderTextFormat();
        $result = $renderer->render($registry->getMetricFamilySamples());

        return response($result)->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }

}

