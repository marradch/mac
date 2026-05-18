<?php

namespace App\Service;

use App\Repository\DeckRepository;

class DeckService
{
    public function __construct(
        private DeckRepository $deckRepository
    ) {}

    public function findAllByLocale(string $locale): array
    {
        return $this->deckRepository->findAllByLocale($locale);
    }

}
