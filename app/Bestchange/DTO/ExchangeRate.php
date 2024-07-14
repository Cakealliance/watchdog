<?php

declare(strict_types=1);

namespace App\Bestchange\DTO;

class ExchangeRate
{
    public function __construct(
        public readonly int $changer,
        public readonly string $rate,
        public readonly string $rankRate,
        public readonly string $reserve,
        public readonly string $inMin,
        public readonly string $inMax,
        public readonly array $marks,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['changer'],
            $data['rate'],
            $data['rankrate'],
            $data['reserve'],
            $data['inmin'],
            $data['inmax'],
            $data['marks'],
        );
    }
}
