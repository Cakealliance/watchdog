<?php

declare(strict_types=1);

namespace App\Infrastructure;

enum QueueEnum: string
{
    case DEFAULT = 'default';
    case VIRUS_TOTAL_SCAN = 'virus_total_scan';
}
