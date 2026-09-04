<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class EmotionAndCardDTO implements InterpretDTOInterface
{
    public function __construct(
        /**
             * @var array[] cards with structure: [{"stateSlug": string, "card": {"imageUrl": string}}]
             */
            #[Assert\Valid]
            #[Assert\Count(min: 1, minMessage: 'At least one state+card item is required')]
            public array $cards = [],
    ) {}
}
