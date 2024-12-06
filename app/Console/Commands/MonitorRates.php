<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Notification\Alerts\RatesNotUpdatedAlert;
use App\Services\Notification\NotificationServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\DateFactory;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;
use Throwable;

class MonitorRates extends Command
{
    protected $signature = 'rates:monitor';
    protected $description = 'Monitor rates for outdated updates and notify appropriate channels if needed';

    public function __construct(
        private readonly Client $client,
        private readonly LoggerInterface $logger,
        private readonly DateFactory $dateFactory,
        private readonly NotificationServiceInterface $notificationService,
        private readonly Repository $config,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $exportFilesUrlList = $this->getExportFilesUrlList();

        $this->logger->debug(__CLASS__ . ': Starting...', [
            'rate_files_url_list' => $exportFilesUrlList,
        ]);

        if ([] === $exportFilesUrlList) {
            $this->logger->debug(__CLASS__ . ': Empty export files array. Abort.');

            return self::SUCCESS;
        }

        $isSuccessful = true;

        foreach ($exportFilesUrlList as $exportFileUrl) {
            try {
                $response = $this->client->get($exportFileUrl);

                $xml = simplexml_load_string($response->getBody()->getContents());
                $this->processXml($xml, $exportFileUrl);
            } catch (Throwable $e) {
                $isSuccessful = false;

                $this->logger->error(__CLASS__ . ': Failed to check export file.', [
                    'export_file_url' => $exportFileUrl,
                    'exception_message' => $e->getMessage(),
                    'exception_trace' => substr($e->getTraceAsString(), 0, 500),
                ]);

                continue;
            }
        }

        if ($isSuccessful) {
            $this->logger->debug(__CLASS__ . ': Monitor rates finished successfully.', [
                'export_files' => $exportFilesUrlList,
            ]);

            return self::SUCCESS;
        }

        $this->logger->debug(__CLASS__ . ': Finished with errors', [
            'export_files' => $exportFilesUrlList,
        ]);

        return self::FAILURE;
    }

    private function processXml(SimpleXMLElement $xml, string $exportFileUrl): void
    {
        $decodedJson = json_decode(json_encode($xml), true);

        $createdDate = $this->dateFactory->parse($decodedJson['@attributes']['created']);
        $now = $this->dateFactory->now();
        $minutesNotifyLimit = $this->config->get('websites.exchangers_rates_notify_limit_minutes');

        if ($createdDate->diffInMinutes($now) > $minutesNotifyLimit) {
            $this->notificationService->sendAlert(
                new RatesNotUpdatedAlert(
                    'Курси не оновлюються більше 5 хвилин!',
                    $exportFileUrl,
                )
            );
        }
    }

    private function getExportFilesUrlList(): array
    {
        $urlList = [];
        foreach ($this->config->get('websites.exchangers') as $info) {
            $urlList[] = $info['export_file_url'];
        }

        return $urlList;
    }
}
