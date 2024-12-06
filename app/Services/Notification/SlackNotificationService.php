<?php

declare(strict_types=1);

namespace App\Services\Notification;

use App\External\Slack\Client\Client;
use App\Services\Notification\Alerts\AlertInterface;
use App\Services\Notification\Alerts\RatesNotUpdatedAlert;
use Exception;
use Illuminate\Contracts\Config\Repository;
use LogicException;
use Psr\Log\LoggerInterface;
use Throwable;

class SlackNotificationService implements NotificationServiceInterface
{
    public function __construct(
        private readonly Client $slackClient,
        private readonly LoggerInterface $logger,
        private readonly Repository $config,
    ) {
    }

    public function sendAlert(AlertInterface $alert): bool
    {
        try {
            return match (get_class($alert)) {
                RatesNotUpdatedAlert::class => $this->sendRatesNotUpdatedAlert($alert),
                default => throw new LogicException('Unsupported alert.'),
            };
        } catch (Throwable $e) {
            $this->logger->error(__CLASS__ . ': Failed to send alert.', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => substr($e->getTraceAsString(), 0, 500),
            ]);

            return false;
        }
    }

    /**
     * @throws Exception
     */
    private function sendRatesNotUpdatedAlert(RatesNotUpdatedAlert $alert): bool
    {
        $this->slackClient->sendMessageToChannel(
            $this->resolveChannelName($alert->getExportFileUrl()),
            $this->generateMessage($alert->getMessage()),
        );

        return true;
    }

    private function resolveChannelName(string $exportFileUrl): string
    {
        $exchangers = $this->config->get('websites.exchangers');

        $parsedUrl = parse_url($exportFileUrl);
        $targetExchanger = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

        foreach ($exchangers as $ptNumber => $exchangerDomain) {
            if ($targetExchanger !== $exchangerDomain) {
                continue;
            }

            return "#it-пк-$ptNumber";
        }

        throw new LogicException('Could not resolve target channel.');
    }

    private function generateMessage(string $originalMessage): string
    {
        return '<!here> :bangbang: УВАГА :bangbang:' . PHP_EOL . $originalMessage;
    }
}
