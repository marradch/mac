<?php

namespace App\Factory;

use App\Entity\Exercise;
use App\Entity\SpreadCard;
use App\DTO\Output\ExerciseOutputDTO;

class ExerciseOutputDTOFactory {
    public function makeExerciseOutputDTO(Exercise $exercise): ExerciseOutputDTO
    {
        $translation = $exercise->getTranslations()->first();

        $dto = new ExerciseOutputDTO();
        $dto->id = $exercise->getId();
        $dto->slug = $exercise->getSlug();
        $dto->minExecutionMin = $exercise->getMinExecutionMin();
        $dto->maxExecutionMin = $exercise->getMaxExecutionMin();
        $dto->difficulty = $exercise->getDifficulty()->value;

        if ($translation) {
            $dto->title = $translation?->getTitle();
            $dto->description = $translation?->getShortDescription();
        }

        return $dto;
    }

    public function makeExerciseOutputDTOs(array $exercises): array
    {
        return array_map(fn(Exercise $exercise) => $this->makeExerciseOutputDTO($exercise), $exercises);
    }

    public function makeExerciseOutputDTOForExercisePage(Exercise $exercise, array $cards): ExerciseOutputDTO
    {
        $translation = $exercise->getTranslations()->first();

        $dto = new ExerciseOutputDTO();
        $dto->id = $exercise->getId();
        $dto->slug = $exercise->getSlug();
        $dto->title = $translation?->getTitle();
        $dto->description = $translation?->getDescription();
        $dto->seoTitle = $translation?->getSeoTitle();
        $dto->seoDescription = $translation?->getSeoDescription();
        $dto->minExecutionMin = $exercise->getMinExecutionMin();
        $dto->maxExecutionMin = $exercise->getMaxExecutionMin();
        $dto->difficulty = $exercise->getDifficulty()->value;
        $dto->spread = array_map(function (SpreadCard $card) {
            $translation = $card->getSpreadCardTranslations()->first();

            return [
                'slug' => $card->getSlug(),
                'title' => $translation?->getTitle(),
            ];
        }, $cards);

        return $dto;
    }
}
