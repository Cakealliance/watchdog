<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Log\LogManager;
use Illuminate\Support\Str;

class AddProcessIdToLoggerContext
{
    public function __construct(
        private readonly LogManager $logManager,
    ) {
    }

    public function handle(): void
    {
        $this->logManager->shareContext([
            'process_id' => (string) Str::uuid(),
        ]);
    }
}
