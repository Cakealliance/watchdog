<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\QueueEnum;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        RateLimiter::for(QueueEnum::VIRUS_TOTAL_SCAN->value, fn() => Limit::perMinute(4));
    }
}
