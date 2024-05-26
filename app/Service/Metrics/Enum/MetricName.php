<?php

declare(strict_types=1);

namespace App\Service\Metrics\Enum;

enum MetricName: string
{
    case TODAY_LOADING_TIMES = 'today_loading_times';
    case TODAY_CHECKS_LOADING_TIMES = 'today_checks_loading_times';
    case TODAY_FAILED_CHECKS_LOADING_TIMES = 'today_failed_checks_loading_times';
    case TODAY_AVERAGE_LOADING_TIME = 'today_average_loading_time';
    case YESTERDAY_CHECKS_LOADING_TIMES = 'yesterday_checks_loading_times';
    case YESTERDAY_FAILED_CHECKS_LOADING_TIMES = 'yesterday_failed_checks_loading_times';
    case YESTERDAY_AVERAGE_LOADING_TIME = 'yesterday_average_loading_time';
    case YESTERDAY_LOADING_TIMES ='yesterday_loading_times';
//    case YESTERDAY_CHECKS_LOADING_TIMES = 'yesterday_checks_loading_times';

}
