<?php

declare(strict_types=1);

namespace App\Service\Metrics;

use App\Models\HealthcheckRegistryItem;
use Carbon\Carbon;

class LoadingTimeMetrics
{
    public function __construct(
        private readonly HealthcheckRegistryItem,
    ){
    }

    public function getMetrics(Carbon $day)
    {

    }

}

