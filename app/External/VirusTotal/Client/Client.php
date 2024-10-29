<?php

declare(strict_types=1);

namespace App\External\VirusTotal\Client;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    private string $apiKey;
    private string $baseUrl = 'https://www.virustotal.com/api/v3';

    public function __construct(
        private readonly GuzzleClient $httpClient,
        private readonly Repository $config,
        private readonly LoggerInterface $logger,
    ) {
        $this->apiKey = $this->config->get('services.virus_total.api_key');
    }

    /**
     * @throws Exception
     */
    public function scanUrl(string $url): string
    {
        $endpoint = "$this->baseUrl/urls";

        $payload = [
            'form_params' => [
                'url' => $url,
            ],
            'headers' => [
                'accept' => 'application/json',
                'x-apikey' => $this->apiKey,
            ],
        ];

        $this->logger->debug(__CLASS__ . ': Sending URL scan request', compact('endpoint', 'payload'));

        try {
            $response = $this->httpClient->post($endpoint, $payload);
            $bodyContent = $response->getBody()->getContents();

            if (Response::HTTP_OK !== $response->getStatusCode()) {
                $this->logger->error(__CLASS__ . ": Failed to initiate scan for URL", [
                    'url' => $url,
                    'status_code' => $response->getStatusCode(),
                    'response_body' => $bodyContent,
                ]);

                throw new Exception("Failed to initiate scan for URL.");
            }

            $this->logger->debug(__CLASS__ . ':Received response for URL scan', [
                'status_code' => $response->getStatusCode(),
                'body' => $bodyContent,
            ]);

            $responseData = json_decode($bodyContent, true);

            return $responseData['data']['id'] ?? throw new Exception("No analysis ID received from VirusTotal.");
        } catch (GuzzleException $e) {
            $this->logger->error(__CLASS__ . ": Error occurred while scanning URL", [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            throw new Exception("Error occurred while scanning URL.", 0, $e);
        }
    }

    /**
     * @throws Exception
     */
    public function getUrlAnalysisReport(string $id): array
    {
        $endpoint = "$this->baseUrl/analyses/$id";

        $headers = [
            'headers' => [
                'accept' => 'application/json',
                'x-apikey' => $this->apiKey,
            ],
        ];

        $this->logger->debug(__CLASS__ . ': Sending request for URL analysis report', compact('endpoint', 'headers'));

        try {
            $response = $this->httpClient->get($endpoint, $headers);
            $bodyContent = $response->getBody()->getContents();

            if (Response::HTTP_OK !== $response->getStatusCode()) {
                $this->logger->error(__CLASS__ . ": Failed to retrieve analysis report", [
                    'analysis_id' => $id,
                    'status_code' => $response->getStatusCode(),
                    'response_body' => $bodyContent,
                ]);
                throw new Exception("Failed to retrieve analysis report.");
            }

            $this->logger->debug(__CLASS__ . ': Received response for URL analysis report', [
                'status_code' => $response->getStatusCode(),
                'body' => $bodyContent,
            ]);

            return json_decode($bodyContent, true);
        } catch (GuzzleException $e) {
            $this->logger->error(__CLASS__ . ": Error occurred while retrieving analysis report", [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            throw new Exception("Error occurred while retrieving analysis report.", 0, $e);
        }
    }
}
