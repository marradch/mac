<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
#[ORM\Table(name: 'exercise')]
#[ORM\UniqueConstraint(name: 'uniq_exercise_slug', columns: ['slug'])]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private string $slug;

    #[ORM\OneToMany(
    mappedBy: 'exercise',
    targetEntity: ExerciseTranslation::class,
    cascade: ['persist', 'remove'],
    orphanRemoval: true
    )]
    private Collection $translations;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $show = false;

    #[ORM\Column(options: ['default' => 1])]
    private ?int $orderInList = 1;

    #[ORM\OneToOne(inversedBy: 'exercise', cascade: ['persist', 'remove'])]
    private ?Spread $spread = null;

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

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(ExerciseTranslation $translation): void
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setExercise($this);
        }
    }

    public function removeTranslation(ExerciseTranslation $translation): void
    {
        if ($this->translations->removeElement($translation)) {
            if ($translation->getExercise() === $this) {
                $translation->setExercise(null);
            }
        }
    }

    public function isShow(): ?bool
    {
        return $this->show;
    }

    public function setShow(bool $show): static
    {
        $this->show = $show;

        return $this;
    }

    public function getOrderInList(): ?int
    {
        return $this->orderInList;
    }

    public function setOrderInList(int $orderInList): static
    {
        $this->orderInList = $orderInList;

        return $this;
    }

    public function getSpread(): ?Spread
    {
        return $this->spread;
    }

    public function setSpread(?Spread $spread): static
    {
        $this->spread = $spread;

        return $this;
    }
}
