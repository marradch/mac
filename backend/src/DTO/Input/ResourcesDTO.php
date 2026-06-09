<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class ResourcesDTO implements InterpretDTOInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Query is required')]
        public ?string $query,

        #[Assert\Valid]
        #[Assert\Count(min: 1, minMessage: 'At least one future card required', maxMessage: 'Max 3 future cards allowed')]
        public array $cards = [],
    ) {}
}
