<?php

namespace App\Factory;

use App\Entity\Deck;
use App\DTO\Output\DeckOutputDTO;

class DeckOutputDTOFactory {
    public function makeDeckOutputDTO(Deck $deck): DeckOutputDTO
    {
        $translation = $deck->getTranslations()->first();

        $dto = new DeckOutputDTO();
        $dto->id = $deck->getId();
        $dto->slug = $deck->getSlug();
        $dto->title = $translation?->getTitle();

        return $dto;
    }

    public function makeDeckOutputDTOs(array $decks): array
    {
        return array_map(fn(Deck $deck) => $this->makeDeckOutputDTO($deck), $decks);
    }
}
