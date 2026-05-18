<?php

namespace App\Entity;

use App\Repository\DeckRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeckRepository::class)]
class Deck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $cardsCount = null;

    #[ORM\Column(options: ['default' => 1])]
    private ?int $orderInList = 1;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $show = false;

    #[ORM\OneToMany(
    mappedBy: 'deck',
    targetEntity: DeckTranslation::class,
    cascade: ['persist', 'remove'],
    orphanRemoval: true
    )]
    private Collection $translations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCardsCount(): ?int
    {
        return $this->cardsCount;
    }

    public function setCardsCount(int $cardsCount): static
    {
        $this->cardsCount = $cardsCount;

        return $this;
    }

    public function getOrderInList(): ?int
    {
        return $this->orderInList;
    }

    public function setOrderInList(?int $orderInList): static
    {
        $this->orderInList = $orderInList;

        return $this;
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

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(DeckTranslation $translation): void
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setExercise($this);
        }
    }
}
