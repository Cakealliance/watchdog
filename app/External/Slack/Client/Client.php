<?php

declare(strict_types=1);

namespace App\External\Slack\Client;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    private string $webhookUrl;

    public function __construct(
        private readonly GuzzleClient $httpClient,
        private readonly Repository $config,
    ) {
        $this->webhookUrl = $this->config->get('services.slack.webhook_url');
    }

    /**
     * @throws Exception
     */
    public function sendMessage(string $message): void
    {
        $payload = [
            'json' => [
                'text' => $message,
            ]
        ];

        try {
            $response = $this->httpClient->post($this->webhookUrl, $payload);

            if (Response::HTTP_OK !== $response->getStatusCode()) {
                throw new Exception("Failed to send message to Slack: {$response->getBody()}");
            }
        } catch (GuzzleException $e) {
            throw new Exception("Error occurred while sending message to Slack: " . $e->getMessage(), 0, $e);
        }
    }
}
