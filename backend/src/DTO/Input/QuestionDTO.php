<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class QuestionDTO implements InterpretDTOInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Query is required')]
        #[Assert\Length(min: 3, minMessage: 'Query must be at least 3 characters long')]
        #[Assert\Regex(
            pattern: '/^(.)\1*$/u',
            match: false,
            message: 'Query must not contain only repeated characters'
        )]
        public ?string $query,

        #[Assert\Valid]
        #[Assert\Count(min: 1, max: 3, minMessage: 'At least one card required', maxMessage: 'Max 3 cards allowed')]
        public array $cards = [],
    ) {}
}
