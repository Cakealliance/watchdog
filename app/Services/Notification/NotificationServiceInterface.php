<?php

declare(strict_types=1);

namespace App\Services\Notification;

use App\Services\Notification\Alerts\AlertInterface;

interface NotificationServiceInterface
{
    public function sendAlert(AlertInterface $alert): bool;
}
