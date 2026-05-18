<?php

namespace App\AI\DTO;

final class MetaphoricalCard
{
    public function __construct(
        public ?string $imageUrl,
        public ?string $title = null,
        public ?string $meaning = null,
    ) {}
}
