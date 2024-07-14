<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Bestchange\BrandDictionary;
use App\Bestchange\Client;
use App\Bestchange\DTO\Changer;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Prometheus\CollectorRegistry;
use Psr\Log\LoggerInterface;

class BestchangeObserverCommand extends Command
{
    private const LARAVEL_BRANDS = [
        1, 3, 5, 6, 7, 16, 21, 22
    ];

    private const STATUS_DISABLED = 0.1;
    private const STATUS_ACTIVE = 1;
    private const STATUS_UNAVAILABLE = 2;

    private const TIMEOUT_SECONDS = 15;

    protected $signature = 'bestchange:observe';

    private CollectorRegistry $collectorRegistry;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly Client $client,
    ) {
        parent::__construct();
    }

    public function handle(CollectorRegistry $collectorRegistry): void
    {
        $this->collectorRegistry = $collectorRegistry->getDefault();
        $observedSites = config('healthcheck.targets');

        $changers = $this->client->changers();
        foreach ($observedSites as $brandId => $url) {
            if (in_array($brandId, self::LARAVEL_BRANDS, true)) {
                $this->processOne($brandId, $url, $changers);
            }
        }
    }

    private function processOne(int $brandId, string $url, Collection $changers): void
    {
        $changerId = BrandDictionary::getIdByBrandId($brandId);
        if (null === $changerId) {
            $this->logger->warning('BC changer id resolve failed, skipping...', [
                'brand_id' => $brandId,
                'url' => $url,
            ]);
            return;
        }

        $changer = $this->findChanger($changerId, $changers);
        $metric = $this->collectorRegistry->getOrRegisterGauge(
            "Watchdog",
            "status_on_bestchange" . $brandId,
            "Status of the website on Bestchange",
        );
        if (true === $changer->active) {
            $response = Http::timeout(self::TIMEOUT_SECONDS)->get($url . '/api/general-info');
            if (false === $response->ok()) {
                $this->logger->error('Failed to load /api/general-info', [
                    'base_url' => $url,
                    'brand_id' => $brandId,
                    'response_status' => $response->status(),
                    'response_body' => $response->body(),
                ]);
                $metric->set(self::STATUS_DISABLED);
                return;
            }
            $isInMaintenanceMode = json_decode(
                $response->body(),
                true
            )['data']['maintenance_mode']['enabled'];


            $metric->set($isInMaintenanceMode ? self::STATUS_DISABLED : self::STATUS_ACTIVE);
        } else {
            $metric->set(self::STATUS_DISABLED);
        }
    }

    private function findChanger(int $id, Collection $changers): Changer
    {
        /** @var Changer $changer */
        foreach ($changers as $changer) {
            if ($id === $changer->id) {
                return $changer;
            }
        }

        throw new \RuntimeException("Failed to find BC Changer");
    }
}
