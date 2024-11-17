<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Infrastructure\QueueEnum;
use App\Jobs\LaunchVirusTotalScan;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository;
use Throwable;

class VirusTotalScanCommand extends Command
{
    protected $signature = 'virus-total:scan';

    protected $description = 'Scans all websites using Virus Total API.';

    public function handle(
        Repository $config,
        Dispatcher $dispatcher,
    ): int {
        try {
            $websites = array_merge(
                $config->get('websites.exchangers'),
                $config->get('websites.premium_exchangers'),
                [$config->get('websites.kursoff.web')]
            );

            $dispatcher->dispatch((new LaunchVirusTotalScan($websites))->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value));

            $this->info("VirusTotal scan job dispatched successfully.");

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}
