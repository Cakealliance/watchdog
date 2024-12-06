<?php

declare(strict_types=1);

namespace App\Services\Notification\Alerts;

interface AlertInterface
{
    public function getMessage(): string;
}
