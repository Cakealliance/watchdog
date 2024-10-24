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
use Prometheus\Gauge;
use Psr\Log\LoggerInterface;

class BestchangeObserverCommand extends Command
{
    private const LARAVEL_BRANDS = [
        1, 2, 3, 5, 6, 7, 10, 11, 12, 16, 21, 22
    ];

    private const STATUS_DISABLED_BY_BESTCHANGE = 0.5;
    private const STATUS_ACTIVE = 1;
    private const STATUS_UNAVAILABLE = 0.1; // technical works
    private const STATUS_SERVER_ERROR = 0.2;

    private const TIMEOUT_SECONDS = 15;

    protected $signature = 'bestchange:observe';

    private CollectorRegistry $collectorRegistry;
    private Gauge $claimGauge;
    private Gauge $neutralGauge;
    private Gauge $positiveGauge;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly Client $client,
    ) {
        parent::__construct();
    }

    public function handle(CollectorRegistry $collectorRegistry): void
    {
        $this->collectorRegistry = $collectorRegistry->getDefault();
        $this->claimGauge = $this->collectorRegistry->getOrRegisterGauge(
            'bestchange_ru_reviews', 'claim', 'Active financial claims', ['project']
        );
        $this->neutralGauge = $this->collectorRegistry->getOrRegisterGauge(
            'bestchange_ru_reviews', 'neutral', 'Negative reviews', ['project']
        );
        $this->positiveGauge = $this->collectorRegistry->getOrRegisterGauge(
            'bestchange_ru_reviews', 'positive', 'Positive reviews', ['project']
        );

        $observedSites = config('healthcheck.targets');

        $changers = $this->client->changers();

        foreach ($observedSites as $brandId => $url) {
            try {
                if (in_array($brandId, self::LARAVEL_BRANDS, true)) {
                    $this->processOne($brandId, $url, $changers);
                }
            } catch (\Throwable $exception) {
                $this->logger->error(__CLASS__ . ": processing failed", [
                    'brand_id' => $brandId,
                    'url' => $url,
                    'error_message' => $exception->getMessage(),
                    'trace' => substr($exception->getTraceAsString(), 0, 1000),
                ]);

                continue;
            }
        }
    }

    private function collectReviewsMetrics(Changer $changer): void
    {
        $this->claimGauge->set($changer->reviews->claim, [$changer->name]);
        $this->neutralGauge->set($changer->reviews->neutral, [$changer->name]);
        $this->positiveGauge->set($changer->reviews->positive, [$changer->name]);
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

        $this->collectReviewsMetrics($changer);

        $metric = $this->collectorRegistry->getOrRegisterGauge(
            "Watchdog",
            "status_on_bestchange" . $brandId,
            "Status of the website on Bestchange",
        );
        if (false === $changer->active) {
            $metric->set(self::STATUS_DISABLED_BY_BESTCHANGE);
            return;
        }

        $response = Http::timeout(self::TIMEOUT_SECONDS)->get($url . '/api/general-info');
        if (false === $response->ok()) {
            $this->logger->error('Failed to load /api/general-info', [
                'base_url' => $url,
                'brand_id' => $brandId,
                'response_status' => $response->status(),
                'response_body' => $response->body(),
            ]);
            $metric->set(self::STATUS_SERVER_ERROR);
            return;
        }
        $isInMaintenanceMode = json_decode(
            $response->body(),
            true
        )['data']['maintenance_mode']['enabled'];

        $metric->set($isInMaintenanceMode ? self::STATUS_UNAVAILABLE : self::STATUS_ACTIVE);
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
