<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class QuestionDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Query is required')]
        public ?string $query,

        #[Assert\NotBlank(message: 'Card URL is required')]
        #[Assert\Url(message: 'Invalid image URL')]
        public ?string $cardUrl,
    ) {}
}
