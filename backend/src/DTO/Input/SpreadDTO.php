<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class SpreadDTO implements InterpretDTOInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Query is required')]
        public ?string $query,

        /**
         * @var SpreadCardDTO[]
         */
        #[Assert\Valid]
        #[Assert\Count(min: 1, minMessage: 'At least one card required')]
        public array $cards = [],
    ) {}
}
