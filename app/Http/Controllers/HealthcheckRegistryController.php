<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\HealthcheckRegistryItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HealthcheckRegistryController extends Controller
{
    public function index()
    {
        $siteNames = config('healthcheck.targets');
        $sitesStatusInfo = [];
        $jsData = [];

        foreach ($siteNames as $brandId => $siteName) {
            $monitoredDays = [];
            $jsDays = [];

            /** @var Collection $siteStatusInfo */
            $siteStatusInfo = HealthcheckRegistryItem::where('brand_id', $brandId)->get();
            for($i = 89; $i >= 0; $i--) {
                $monitoredDays[Carbon::now()->subDays($i)->toDateString()] = [
                    "total_checks" => 0,
                    "failed_checks" => -1
                ];

                $registryItem = $siteStatusInfo->where('date', Carbon::now()->subDays($i)->toDateString())->first();
                if (null === $registryItem) {
                    $jsDay = [
                        'date' => Carbon::now()->subDays($i)->toDateString(),
                        'outages' => [
                            "p" => 0,
                            "m" => 0,
                        ],
                        'related_events' => [],
                    ];
                } else {
                    $jsDay = [
                        'date' => Carbon::now()->subDays($i)->toDateString(),
                        'related_events' => [],
                    ];
                    if ($registryItem->failed_checks > 50) {
                        $jsDay['outages'] = [
                            "p" => 0,
                            "m" => $registryItem->failed_checks * 60,
                        ];
                    } elseif ($registryItem->failed_checks > 0) {
                        $jsDay['outages'] = [
                            "p" => $registryItem->failed_checks * 60,
                            "m" => 0,
                        ];
                    } else {
                        $jsDay['outages'] = [
                            "p" => 0,
                            "m" => 0,
                        ];
                    }
                }

                $jsDays[] = $jsDay;
            }

            /** @var HealthcheckRegistryItem $dailySiteStatusInfo */
            foreach ($siteStatusInfo as $dailySiteStatusInfo) {
                if(array_key_exists($dailySiteStatusInfo->date, $monitoredDays)) {
                    $monitoredDays[$dailySiteStatusInfo->date] = [
                        'total_checks' => $dailySiteStatusInfo->total_checks,
                        'failed_checks' => $dailySiteStatusInfo->failed_checks
                    ];
                }
            }

            $sitesStatusInfo[$siteName] = $monitoredDays;
            $jsData[$siteName] = [
                "component" => [
                    "code" => $siteName,
                    "name" => $siteName,
                    'isGroup' => false,
                    "startDate" => key($monitoredDays),
                ],
                "days" => $jsDays,
            ];
        }

        return view('status.index', ['sitesStatusInfo' => $sitesStatusInfo, 'jsData' => $jsData]);
    }
}
