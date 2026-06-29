<?php

namespace App\Entity;

use App\Repository\SpreadCardTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpreadCardTranslationRepository::class)]
class SpreadCardTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'spreadCardTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SpreadCard $spreadCard = null;

    #[ORM\Column(length: 10)]
    private ?string $locale = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpreadCard(): ?SpreadCard
    {
        return $this->spreadCard;
    }

    public function setSpreadCard(?SpreadCard $spreadCard): static
    {
        $this->spreadCard = $spreadCard;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
