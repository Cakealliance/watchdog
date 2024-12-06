<?php

declare(strict_types=1);

namespace App\Providers;

use App\External\Slack\Client\Client as SlackClient;
use App\External\Slack\Client\DummyClient as DummySlackClient;
use App\Services\Notification\NotificationServiceInterface;
use App\Services\Notification\SlackNotificationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        NotificationServiceInterface::class => SlackNotificationService::class,
    ];

    public function register(): void
    {
        if ('local' === $this->app->environment()) {
            $this->app->singleton(SlackClient::class, DummySlackClient::class);
        }
    }

    public function boot(): void
    {
    }
}
