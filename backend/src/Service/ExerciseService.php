<?php

namespace App\Service;

use App\Repository\ExerciseRepository;
use App\Entity\Exercise;

class ExerciseService
{
    public function __construct(
        private ExerciseRepository $exerciseRepository
    ) {}

    public function findAllByLocale(string $locale): array
    {
        return $this->exerciseRepository->findAllByLocale($locale);
    }

    public function findOneBySlugAndLocale(string $locale, string $slug): Exercise
    {
        return $this->exerciseRepository->findOneBySlugAndLocale($locale, $slug);
    }
}
