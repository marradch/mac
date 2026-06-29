<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'psychological_state_translation')]
#[ORM\UniqueConstraint(
    name: 'uniq_psychological_state_locale',
    columns: ['psychological_state_id', 'locale']
)]
class PsychologicalStateTranslation {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: PsychologicalState::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?PsychologicalState $psychologicalState = null;

    #[ORM\Column(length: 10)]
    private string $locale;

    #[ORM\Column(length: 200)]
    private string $title;

    public function getId(): ?int {
        return $this->id;
    }

    public function getPsychologicalState(): ?PsychologicalState {
        return $this->psychologicalState;
    }

    public function setPsychologicalState(?PsychologicalState $psychologicalState): void {
        $this->psychologicalState = $psychologicalState;
    }

    public function getLocale(): string {
        return $this->locale;
    }

    public function setLocale(string $locale): void {
        $this->locale = $locale;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }
}
