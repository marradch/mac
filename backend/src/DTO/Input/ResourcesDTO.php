<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class ResourcesDTO implements InterpretDTOInterface
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
        #[Assert\Count(min: 1, minMessage: 'At least one future card required')]
        public array $cards = [],
    ) {}
}
