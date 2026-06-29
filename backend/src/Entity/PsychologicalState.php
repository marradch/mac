<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'psychological_state')]
#[ORM\UniqueConstraint(name: 'uniq_psychological_state_slug', columns: ['slug'])]
class PsychologicalState
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private string $slug;

    #[ORM\OneToMany(
        mappedBy: 'psychologicalState',
        targetEntity: PsychologicalStateTranslation::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(PsychologicalStateTranslation $translation): void
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setPsychologicalState($this);
        }
    }

    public function removeTranslation(PsychologicalStateTranslation $translation): void
    {
        if ($this->translations->removeElement($translation)) {
            if ($translation->getPsychologicalState() === $this) {
                $translation->setPsychologicalState(null);
            }
        }
    }
}
