<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class TimeSpreadDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Query is required')]
        public ?string $query,

        #[Assert\Valid]
        #[Assert\Count(min: 1, max: 3, minMessage: 'At least one past card required', maxMessage: 'Max 3 past cards allowed')]
        public array $past = [],

        #[Assert\Valid]
        #[Assert\Count(min: 1, max: 3, minMessage: 'At least one present card required', maxMessage: 'Max 3 present cards allowed')]
        public array $present = [],

        #[Assert\Valid]
        #[Assert\Count(min: 1, max: 3, minMessage: 'At least one future card required', maxMessage: 'Max 3 future cards allowed')]
        public array $future = [],
    ) {}
}
