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
use Throwable;

class MonitorRates extends Command
{
    protected $signature = 'rates:monitor';
    protected $description = 'Monitor rates for outdated updates and notify appropriate channels if needed';

    private array $exportFiles;

    public function __construct(
        private readonly Client $client,
        private readonly LoggerInterface $logger,
        private readonly DateFactory $dateFactory,
        private readonly NotificationServiceInterface $notificationService,
        private readonly Repository $config,
    ) {
        $this->exportFiles = $this->config->get('rate_monitoring.export_files', []);

        parent::__construct();
    }

    public function handle(): int
    {
        if ([] === $this->exportFiles) {
            return self::SUCCESS;
        }

        foreach ($this->exportFiles as $exportFile) {
            try {
                $response = $this->client->get($exportFile);
                $xml = simplexml_load_string($response->getBody()->getContents());
                $decodedJson = json_decode(json_encode($xml), true);

                $createdDate = $this->dateFactory->parse($decodedJson['@attributes']['created']);
                $now = $this->dateFactory->now();
                $minutesNotifyLimit = $this->config->get('rate_monitoring.notify_limit_minutes');

                if ($createdDate->diffInMinutes($now) > $minutesNotifyLimit) {
                    $this->notificationService->sendAlert(
                        new RatesNotUpdatedAlert(
                            'Курси не оновлюються більше 5 хвилин!',
                            $exportFile,
                        )
                    );
                }
            } catch (Throwable $e) {
                $this->logger->error(__CLASS__ . ': Failed to check export file.', [
                    'export_file' => $exportFile,
                    'exception_message' => $e->getMessage(),
                    'exception_trace' => substr($e->getTraceAsString(), 0, 500),
                ]);

                continue;
            }
        }

        return self::SUCCESS;
    }
}
