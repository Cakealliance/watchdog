<?php

declare(strict_types=1);

namespace App\Exceptions\Contracts;

interface ReportableToSlackInterface
{
    public function toSlack(): string;
}
