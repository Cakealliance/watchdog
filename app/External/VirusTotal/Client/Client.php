<?php

declare(strict_types=1);

namespace App\External\VirusTotal\Client;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository;

class Client
{
    private string $apiKey;
    private string $baseUrl = 'https://www.virustotal.com/api/v3';

    public function __construct(
        private readonly GuzzleClient $httpClient,
        private readonly Repository $config,
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

        try {
            $response = $this->httpClient->post($endpoint, $payload);

            if (200 !== $response->getStatusCode()) {
                throw new Exception("Failed to initiate scan for URL: {$url}");
            }

            $responseData = json_decode($response->getBody()->getContents(), true);
            return $responseData['data']['id'] ?? throw new Exception("No analysis ID received from VirusTotal.");
        } catch (GuzzleException $e) {
            throw new Exception("Error occurred while scanning URL: " . $e->getMessage(), 0, $e);
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

        try {
            $response = $this->httpClient->get($endpoint, $headers);

            if (200 !== $response->getStatusCode()) {
                throw new Exception("Failed to retrieve analysis report for ID: {$id}");
            }

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new Exception("Error occurred while retrieving analysis report: " . $e->getMessage(), 0, $e);
        }
    }
}
