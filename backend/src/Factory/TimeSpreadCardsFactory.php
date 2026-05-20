<?php

namespace App\Factory;

use App\AI\DTO\MetaphoricalCard;
use App\DTO\Input\TimeSpreadDTO;

class TimeSpreadCardsFactory {
    public function makeTimeSpreadCardsArray(TimeSpreadDTO $dto): array
    {
        $result = [];
        foreach (['past', 'present', 'future'] as $timePeriod) {
            $timeCards = $dto->{$timePeriod};
            foreach ($timeCards as $card) {
                $result[$timePeriod][] = new MetaphoricalCard($card['imageUrl']);
            }
        }

        return $result;
    }
}
