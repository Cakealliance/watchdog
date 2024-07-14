<?php

declare(strict_types=1);

namespace App\Bestchange\DTO;

class Changer
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly array $langs,
        public readonly array $urls,
        public readonly array $pages,
        public readonly int $reserve,
        public readonly ChangerReviews $reviews,
        public readonly int $rating,
        public readonly bool $active,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['langs'],
            $data['urls'],
            $data['pages'],
            $data['reserve'],
            ChangerReviews::fromArray($data['reviews']),
            $data['rating'],
            $data['active'],
        );
    }
}
