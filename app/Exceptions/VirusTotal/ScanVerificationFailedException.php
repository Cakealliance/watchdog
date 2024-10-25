<?php

declare(strict_types=1);

namespace App\Exceptions\VirusTotal;

use Throwable;

class ScanVerificationFailedException extends AbstractVirusTotalScanException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous, $message);
    }
}
