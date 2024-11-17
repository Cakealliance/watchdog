<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Contracts\ReportableToSlackInterface;
use App\External\Slack\Client\Client as SlackClient;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psr\Log\LoggerInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            /** @var Repository $config */
            $config = $this->container->make(Repository::class);
            /** @var LoggerInterface $logger */
            $logger = $this->container->make(LoggerInterface::class);

            if ($config->get('app.sentry_enabled') && $this->container->bound('sentry')) {
                $this->container->make('sentry')->captureException($e);
            }

            if ($e instanceof ReportableToSlackInterface) {
                /** @var SlackClient $slackClient */
                $slackClient = $this->container->make(SlackClient::class);
                if ('production' === $config->get('app.env')) {
                    $slackClient->sendMessage($e->toSlack());
                } else {
                    $logger->debug('Sending error message to Slack.', [
                        'message' => $e->toSlack(),
                    ]);
                }
            }
        });
    }
}
