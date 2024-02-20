<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $site_name
 * @property int $brand_id
 * @property string $date
 * @property int $total_checks
 * @property int $failed_checks
 * @property array|null $failed_checks_timestamps
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class HealthcheckRegistryItem extends Model
{
    protected $table = 'healthcheck_registry';

    protected $casts = [
        'failed_checks_timestamps' => 'array'
    ];
}
