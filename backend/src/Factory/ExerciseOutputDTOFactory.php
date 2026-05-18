<?php

namespace App\Factory;

use App\Entity\Exercise;
use App\DTO\Output\ExerciseOutputDTO;

class ExerciseOutputDTOFactory {
    public function makeExerciseOutputDTO(Exercise $exercise): ExerciseOutputDTO
    {
        $translation = $exercise->getTranslations()->first();

        $dto = new ExerciseOutputDTO();
        $dto->id = $exercise->getId();
        $dto->slug = $exercise->getSlug();
        $dto->title = $translation?->getTitle();
        $dto->description = $translation?->getShortDescription();

        return $dto;
    }

    public function makeExerciseOutputDTOs(array $exercises): array
    {
        return array_map(fn(Exercise $exercise) => $this->makeExerciseOutputDTO($exercise), $exercises);
    }

    public function makeExerciseOutputDTOForExercisePage(Exercise $exercise): ExerciseOutputDTO
    {
        $translation = $exercise->getTranslations()->first();

        $dto = new ExerciseOutputDTO();
        $dto->id = $exercise->getId();
        $dto->slug = $exercise->getSlug();
        $dto->title = $translation?->getTitle();
        $dto->description = $translation?->getDescription();
        $dto->seo_title = $translation?->getSeoTitle();
        $dto->seo_description = $translation?->getSeoDescription();

        return $dto;
    }
}
