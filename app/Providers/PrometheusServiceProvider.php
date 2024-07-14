<?php

declare(strict_types=1);

namespace App\Providers;

use App\Metrics\PrometheusService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class PrometheusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton( CollectorRegistry::class, function () {

            Redis::setDefaultOptions(
                Arr::only( config( 'database.redis.default' ), [ 'host', 'password', 'username' ] )
            );

            return CollectorRegistry::getDefault();

        } );

        $this->app->singleton( PrometheusService::class, PrometheusService::class );
    }

    public function boot(): void
    {
        //
    }
}
