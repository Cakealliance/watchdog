<?php

namespace App\Exceptions;

use App\Exceptions\Contracts\ReportableToSlackInterface;
use App\External\Slack\Client\Client as SlackClient;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if (config()->get('app.sentry_enabled') && app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }

            if ($e instanceof ReportableToSlackInterface) {
                /** @var SlackClient $slackClient */
                $slackClient = app(SlackClient::class);
                if ('production' === config()->get('app.env')) {
                    $slackClient->sendMessage($e->toSlack());
                } else {
                    Log::debug('Sending error message to Slack.', [
                        'message' => $e->toSlack(),
                    ]);
                }
            }
        });
    }
}
