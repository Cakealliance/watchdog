<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Infrastructure\QueueEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleVirusTotalChunkScan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(
        private readonly array $websites,
    ) {
    }

    public function handle(
        Dispatcher $dispatcher,
    ): void {
        foreach ($this->websites as $website) {
            $dispatcher->dispatch((new LaunchVirusTotalScan($website))->onQueue(QueueEnum::VIRUS_TOTAL_SCAN->value));
        }
    }
}
