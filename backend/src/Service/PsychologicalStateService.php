<?php

namespace App\Service;

use App\Repository\PsychologicalStateRepository;

class PsychologicalStateService
{
    public function __construct(
        private PsychologicalStateRepository $psychologicalStateRepository
    ) {}

    public function findAllByLocale(string $locale): array
    {
        return $this->psychologicalStateRepository->findAllByLocale($locale);
    }
}
