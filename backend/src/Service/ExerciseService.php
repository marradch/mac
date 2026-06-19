<?php

namespace App\Service;

use App\Repository\ExerciseRepository;
use App\Repository\SpreadCardsRepository;
use App\Entity\Exercise;
use App\Factory\ExerciseOutputDTOFactory;
use App\DTO\Output\ExerciseOutputDTO;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExerciseService
{
    public function __construct(
        private ExerciseRepository $exerciseRepository,
        private SpreadCardsRepository $cardsRepository,
        private ExerciseOutputDTOFactory $dtoFactory
    ) {}

    public function findAllByLocale(string $locale): array
    {
        return $this->exerciseRepository->findAllByLocale($locale);
    }

    public function findOneBySlugAndLocale(string $locale, string $slug): ExerciseOutputDTO
    {
        $exercise = $this->exerciseRepository->findOneBySlugAndLocale($locale, $slug);
        if (!$exercise) {
            throw new NotFoundHttpException(
                sprintf('Exercise "%s" not found"', $slug)
            );
        }

        $cards = ($exercise?->getSpread()) ? $this->cardsRepository->findAllByLocaleAndSpread($locale, $exercise->getSpread()->getId()) : [];

        return $this->dtoFactory->makeExerciseOutputDTOForExercisePage($exercise, $cards);
    }
}
