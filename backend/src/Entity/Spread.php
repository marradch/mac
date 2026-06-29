<?php

namespace App\Entity;

use App\Repository\SpreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpreadRepository::class)]
class Spread
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, SpreadCard>
     */
    #[ORM\OneToMany(targetEntity: SpreadCard::class, mappedBy: 'Ñspread', orphanRemoval: true)]
    private Collection $spreadCards;

    #[ORM\OneToOne(mappedBy: 'spread', cascade: ['persist', 'remove'])]
    private ?Exercise $exercise = null;

    public function __construct()
    {
        $this->spreadCards = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, SpreadCard>
     */
    public function getSpreadCards(): Collection
    {
        return $this->spreadCards;
    }

    public function addSpreadCard(SpreadCard $spreadCard): static
    {
        if (!$this->spreadCards->contains($spreadCard)) {
            $this->spreadCards->add($spreadCard);
            $spreadCard->setÑspread($this);
        }

        return $this;
    }

    public function removeSpreadCard(SpreadCard $spreadCard): static
    {
        if ($this->spreadCards->removeElement($spreadCard)) {
            // set the owning side to null (unless already changed)
            if ($spreadCard->getÑspread() === $this) {
                $spreadCard->setÑspread(null);
            }
        }

        return $this;
    }

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): static
    {
        // unset the owning side of the relation if necessary
        if ($exercise === null && $this->exercise !== null) {
            $this->exercise->setSpread(null);
        }

        // set the owning side of the relation if necessary
        if ($exercise !== null && $exercise->getSpread() !== $this) {
            $exercise->setSpread($this);
        }

        $this->exercise = $exercise;

        return $this;
    }
}
