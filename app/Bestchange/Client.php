<?php

declare(strict_types=1);

namespace App\Bestchange;

use App\Bestchange\DTO\Changer;
use App\Bestchange\DTO\Currency;
use App\Bestchange\DTO\ExchangeRate;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use Throwable;

/**
 * @see https://www.bestchange.app/ #OpenAPI specification
 */
class Client
{
    private const BASE_URI = 'https://www.bestchange.app/v2/';

    private ?GuzzleClient $client = null;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly Repository $config,
    ) {
    }

    private function getClient(): GuzzleClient
    {
        if (null !== $this->client) {
            return $this->client;
        }

        return $this->client = $this->buildClient();
    }

    private function buildClient(): GuzzleClient
    {
        return new GuzzleClient([
            'base_uri' => $this->buildBaseUri(),
        ]);
    }

    private function buildBaseUri(): string
    {
        $apiKey = $this->config->get('bestchange.api_key');

        return self::BASE_URI . $apiKey . '/';
    }

    /**
     * @throws GuzzleException
     * @throws Throwable
     */
    private function makeRequest(string $endpoint): array
    {
        $this->logger->debug('Bestchange API client: trying to make request', [
            'method' => 'GET',
            'url' => $endpoint,
        ]);

        try {
            $timeStart = microtime(true);
            $response = $this->getClient()->get($endpoint);
        } catch (Throwable $e) {
            $this->logger->debug('Bestchange API client error', [
                'method' => 'GET',
                'url' => $endpoint,
                'error_message' => $e->getMessage(),
                'exception' => $e->getTraceAsString()
            ]);

            throw $e;
        }

        $this->logger->debug('Bestchange API client: request was successful', [
            'method' => 'GET',
            'url' => $endpoint,
            'response' => $response->getStatusCode(),
            'time' => microtime(true) - $timeStart,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return Currency[]|Collection
     * @throws Throwable|GuzzleException
     */
    public function currencies(): Collection
    {
        $body = $this->makeRequest('currencies');

        $currencies = new Collection();
        foreach ($body['currencies'] as $item) {
            $currencies->push(Currency::fromArray($item));
        }

        return $currencies;
    }

    /**
     * @return ExchangeRate[]|Collection
     * @throws Throwable|GuzzleException
     */
    public function rates(int $fromCurrencyId, int $toCurrencyId, ?int $cityId): Collection
    {
        if (null === $cityId) {
            $identifier = "$fromCurrencyId-$toCurrencyId";
        } else {
            $identifier = "$fromCurrencyId-$toCurrencyId-$cityId";
        }
        $body = $this->makeRequest("rates/$identifier");

        $rates = new Collection();
        foreach ($body['rates'][$identifier] as $item) {
            $rates->push(ExchangeRate::fromArray($item));
        }

        return $rates;
    }

    /**
     * @return Changer[]|Collection
     * @throws Throwable|GuzzleException
     */
    public function changers(): Collection
    {
        $body = $this->makeRequest("changers");

        $changers = new Collection();
        foreach ($body['changers'] as $item) {
            $changers->push(Changer::fromArray($item));
        }

        return $changers;
    }
}
