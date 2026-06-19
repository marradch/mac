<?php

namespace App\Entity;

use App\Repository\SpreadCardsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpreadCardsRepository::class)]
class SpreadCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, SpreadCardTranslation>
     */
    #[ORM\OneToMany(targetEntity: SpreadCardTranslation::class, mappedBy: 'spreadCard', orphanRemoval: true)]
    private Collection $spreadCardTranslations;

    #[ORM\ManyToOne(inversedBy: 'spreadCards')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Spread $spread = null;

    #[ORM\Column(nullable: true)]
    private ?int $orderInList = null;

    public function __construct()
    {
        $this->locale = new ArrayCollection();
        $this->spreadCardTranslations = new ArrayCollection();
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
     * @return Collection<int, SpreadCardTranslation>
     */
    public function getSpreadCardTranslations(): Collection
    {
        return $this->spreadCardTranslations;
    }

    public function addSpreadCardTranslation(SpreadCardTranslation $spreadCardTranslation): static
    {
        if (!$this->spreadCardTranslations->contains($spreadCardTranslation)) {
            $this->spreadCardTranslations->add($spreadCardTranslation);
            $spreadCardTranslation->setSpreadCard($this);
        }

        return $this;
    }

    public function removeSpreadCardTranslation(SpreadCardTranslation $spreadCardTranslation): static
    {
        if ($this->spreadCardTranslations->removeElement($spreadCardTranslation)) {
            // set the owning side to null (unless already changed)
            if ($spreadCardTranslation->getSpreadCard() === $this) {
                $spreadCardTranslation->setSpreadCard(null);
            }
        }

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

    public function getOrderInList(): ?int
    {
        return $this->orderInList;
    }

    public function setOrderInList(?int $orderInList): static
    {
        $this->orderInList = $orderInList;

        return $this;
    }
}
