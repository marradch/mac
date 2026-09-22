<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class ChoiceDTO implements InterpretDTOInterface
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

        #[Assert\NotBlank(message: 'Option 1 text is required')]
        #[Assert\Length(min: 3, minMessage: 'Query must be at least 3 characters long')]
        #[Assert\Regex(
            pattern: '/^(.)\1*$/u',
            match: false,
            message: 'Query must not contain only repeated characters'
        )]
        public ?string $option1Text,

        #[Assert\NotBlank(message: 'Option 2 text is required')]
        #[Assert\Length(min: 3, minMessage: 'Query must be at least 3 characters long')]
        #[Assert\Regex(
            pattern: '/^(.)\1*$/u',
            match: false,
            message: 'Query must not contain only repeated characters'
        )]
        public ?string $option2Text,

        #[Assert\Valid]
        #[Assert\Count(min: 1, max: 3, minMessage: 'At least one past card required', maxMessage: 'Max 3 past cards allowed')]
        public array $option1Cards = [],

        #[Assert\Valid]
        #[Assert\Count(min: 1, max: 3, minMessage: 'At least one past card required', maxMessage: 'Max 3 past cards allowed')]
        public array $option2Cards = [],

        #[Assert\Type('integer')]
        #[Assert\Choice([1, 2])]
        public ?int $selectedOption = null
    ) {}
}
