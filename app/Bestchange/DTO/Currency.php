<?php

declare(strict_types=1);

namespace App\Bestchange\DTO;

class Currency
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $urlName,
        public readonly string $viewName,
        public readonly string $code,
        public readonly bool $crypto,
        public readonly bool $cash,
        public readonly int $ps,
        public readonly int $group,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['urlname'],
            $data['viewname'],
            $data['code'],
            $data['crypto'],
            $data['cash'],
            $data['ps'],
            $data['group'],
        );
    }
}
