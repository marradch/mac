<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class SpreadCardDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Card name is required')]
        public ?string $title,

        #[Assert\NotBlank(message: 'Card slug is required')]
        public ?string $slug,

        #[Assert\NotBlank(message: 'URL is required')]
        #[Assert\Url(message: 'Invalid URL format')]
        public ?string $imageUrl,
    ) {}
}
