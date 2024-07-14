<?php

declare(strict_types=1);

namespace App\Bestchange\DTO;

class ChangerReviews
{
    public function __construct(
        public readonly int $claim,
        public readonly int $closed,
        public readonly int $neutral,
        public readonly int $positive,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new ChangerReviews(
            $data['claim'],
            $data['closed'],
            $data['neutral'],
            $data['positive'],
        );
    }
}
