<?php

declare(strict_types=1);

namespace App\Exceptions\VirusTotal;

use App\Exceptions\Contracts\ReportableToSlackInterface;
use Exception;
use Throwable;

class AbstractVirusTotalScanException extends Exception implements ReportableToSlackInterface
{
    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null,
        private readonly string $slackMessage = "",
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function toSlack(): string
    {
        return $this->slackMessage;
    }
}