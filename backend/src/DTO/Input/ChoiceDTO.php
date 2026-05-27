<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class ChoiceDTO implements InterpretDTOInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Query is required')]
        public ?string $query,

        #[Assert\NotBlank(message: 'Option 1 text is required')]
        public ?string $option1Text,

        #[Assert\NotBlank(message: 'Option 2 text is required')]
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
