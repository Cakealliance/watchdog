<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Infrastructure\QueueEnum;
use App\Jobs\LaunchVirusTotalScan;
use App\Jobs\ScheduleVirusTotalChunkScan;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository;
use Throwable;

class VirusTotalScan extends Command
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
            $websiteChunks = array_chunk($websites, 4);

            $this->info('Starting the Virus Total scan for websites...' . PHP_EOL);

            $delay = 0;
            $this->withProgressBar($websiteChunks, function ($websiteChunk) use ($dispatcher, &$delay) {
                $dispatcher->dispatch((new ScheduleVirusTotalChunkScan($websiteChunk))
                    ->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value)
                    ->delay($delay)
                );
                $this->info(PHP_EOL . "Dispatched scan jobs for: " . implode(', ', $websiteChunk));
                $delay += 120;
            });

            $this->info(PHP_EOL . 'All scan jobs have been dispatched successfully.');

            return self::SUCCESS;

        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}
