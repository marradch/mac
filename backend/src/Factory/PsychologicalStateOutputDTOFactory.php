<?php

namespace App\Factory;

use App\DTO\Output\PsychologicalStateOutputDTO;
use App\Entity\PsychologicalState;

class PsychologicalStateOutputDTOFactory {
    public function makePsychologicalStateOutputDTO(PsychologicalState $state): PsychologicalStateOutputDTO
    {
        $translation = $state->getTranslations()->first();

        $dto = new PsychologicalStateOutputDTO();
        $dto->slug = $state->getSlug();
        $dto->title = $translation?->getTitle();

        return $dto;
    }

    public function makePsychologicalStateOutputDTOs(array $states): array
    {
        return array_map(fn(PsychologicalState $state) => $this->makePsychologicalStateOutputDTO($state), $states);
    }
}
