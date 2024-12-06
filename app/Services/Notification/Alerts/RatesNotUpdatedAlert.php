<?php

declare(strict_types=1);

namespace App\Services\Notification\Alerts;

class RatesNotUpdatedAlert implements AlertInterface
{
    public function __construct(
        private readonly string $message,
        private readonly string $exportFileUrl,
    ) {
    }

    public function getExportFileUrl(): string
    {
        return $this->exportFileUrl;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
