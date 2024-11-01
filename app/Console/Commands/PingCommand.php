<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Prometheus\CollectorRegistry;
use Prometheus\Gauge;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class PingCommand extends Command
{
    private const TIMEOUT_SECONDS = 15;
    private const API_GENERAL_INFO_ROUTE = '/api/general-info';
    private const API_HEALTHCHECK_ROUTE = '/api/healthcheck';
    private const WEBSERVER_HEALTHCHECK_ROUTE = '/webserver/healthcheck';

    private CollectorRegistry $collectorRegistry;
    private Gauge $mainPageGauge;
    private Gauge $apiGeneralInfoGauge;
    private Gauge $apiHealthcheckGauge;
    private Gauge $webserverHealthcheckGauge;

    protected $signature = 'ping';

    public function handle(LoggerInterface $logger, CollectorRegistry $collectorRegistry): void
    {
        $this->collectorRegistry = $collectorRegistry->getDefault();
        $this->mainPageGauge = $this->collectorRegistry->getOrRegisterGauge(
            'website_speed', 'main_page_load_time', 'Speed of site loading in milliseconds', ['project']
        );
        $this->apiGeneralInfoGauge = $this->collectorRegistry->getOrRegisterGauge(
            'website_speed', 'api_general_info_load_time', 'Speed of /api/general-info loading in milliseconds', ['project']
        );
        $this->apiHealthcheckGauge = $this->collectorRegistry->getOrRegisterGauge(
            'website_speed', 'api_healthcheck_load_time', 'Speed of /api/healthcheck loading in milliseconds', ['project']
        );
        $this->webserverHealthcheckGauge = $this->collectorRegistry->getOrRegisterGauge(
            'website_speed', 'webserver_healthcheck_load_time', 'Speed of /webserver/healthcheck loading in milliseconds', ['project']
        );

        $startTime = Carbon::now();
        $exchangers = config('websites')['exchangers'];

        foreach ($exchangers as $brandId => $url) {
            $this->processOne($brandId, $url, $logger, $this->mainPageGauge);
            $this->processOne($brandId, $url . self::API_GENERAL_INFO_ROUTE, $logger, $this->apiGeneralInfoGauge);
            $this->processOne($brandId, $url . self::API_HEALTHCHECK_ROUTE, $logger, $this->apiHealthcheckGauge);
            $this->processOne($brandId, $url . self::WEBSERVER_HEALTHCHECK_ROUTE, $logger, $this->webserverHealthcheckGauge);
        }
        $this->pingBestchangeApi();

        $logger->info('PingCommand executed successfully', [
            'process_time_s' => Carbon::now()->diffInSeconds($startTime),
            'exchangers_websites' => count($exchangers),
        ]);
    }

    private function processOne(int $brandId, string $url, LoggerInterface $logger, Gauge $gauge): void
    {
        $currentTime = Carbon::now();
        try {
            $responseStatus = Http::timeout(self::TIMEOUT_SECONDS)->get($url)->status();
        } catch (\Throwable $exception) {
            $logger->error('Could not ping observed website', [
                'brand_id' => $brandId,
                'website_url' => $url,
                'exception_message' => $exception->getMessage(),
                'exception_trace' => substr($exception->getTraceAsString(), 0, 500),
            ]);

            return;
        }

        $websiteName = str_replace('https://', '', $url);
        if($responseStatus === Response::HTTP_OK) {
            $gauge->set(Carbon::now()->diffInMilliseconds($currentTime), [$websiteName]);
        } else {
            $gauge->set(0, [$websiteName]);
        }
    }

    private function pingBestchangeApi(LoggerInterface $logger): void
    {
        $gauge = $this->collectorRegistry->getOrRegisterGauge(
            'bestchange_load_speed', 'api', 'Speed of API /changers loading in milliseconds'
        );
        $url = 'https://www.bestchange.app/v2/10b96f533554b06efdc4694ff0dc32eb/changers';

        // Bestchange.ru
        $currentTime = Carbon::now();
        try {
            $ruResponseStatus = Http::timeout(self::TIMEOUT_SECONDS)->get($url)->status();
        } catch (\Throwable $exception) {
            $logger->error('Could not ping Bestchange API', [
                'website_url' => $url,
                'exception_message' => $exception->getMessage(),
                'exception_trace' => substr($exception->getTraceAsString(), 0, 500),
            ]);

            return;
        }


        if($ruResponseStatus === Response::HTTP_OK) {
            $gauge->set(Carbon::now()->diffInMilliseconds($currentTime));
        } else {
            $gauge->set(0);
        }
    }
}
