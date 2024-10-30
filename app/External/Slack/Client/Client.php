<?php

declare(strict_types=1);

namespace App\External\Slack\Client;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    private string $webhookUrl;

    public function __construct(
        private readonly GuzzleClient $httpClient,
        private readonly Repository $config,
        private readonly LoggerInterface $logger,
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

        $this->logger->debug(__CLASS__ . ': Sending message to Slack', [
            'webhook_url' => $this->webhookUrl,
            'payload' => $payload,
        ]);

        try {
            $response = $this->httpClient->post($this->webhookUrl, $payload);
            $bodyContent = $response->getBody()->getContents();

            if (Response::HTTP_OK !== $response->getStatusCode()) {
                $this->logger->error(__CLASS__ . ": Failed to send message to Slack", [
                    'message' => $message,
                    'status_code' => $response->getStatusCode(),
                    'response_body' => substr($bodyContent, 0, 500),
                ]);

                throw new Exception("Failed to send message to Slack.");
            }

            $this->logger->debug(__CLASS__ . ': Received response from Slack', [
                'status_code' => $response->getStatusCode(),
                'body' => substr($bodyContent, 0, 500),
            ]);
        } catch (GuzzleException $e) {
            $this->logger->error(__CLASS__ . ": Error occurred while sending message to Slack", [
                'message' => $message,
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            throw new Exception("Error occurred while sending message to Slack.", 0, $e);
        }
    }
}
