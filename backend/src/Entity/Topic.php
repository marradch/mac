<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
#[ORM\Table(name: 'topic')]
#[ORM\UniqueConstraint(name: 'uniq_topic_slug', columns: ['slug'])]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private string $slug;

    #[ORM\Column(name: 'show_on_homepage', options: ['default' => false])]
    private bool $showOnHomepage = false;

    #[ORM\Column(name: 'homepage_order', options: ['default' => 0])]
    private int $homepageOrder = 0;

    /**
     * @var Collection<int, TopicTranslation>
     */
    #[ORM\OneToMany(
        mappedBy: 'topic',
        targetEntity: TopicTranslation::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $translations;

    /**
     * @var Collection<int, TopicQuestion>
     */
    #[ORM\OneToMany(
        mappedBy: 'topic',
        targetEntity: TopicQuestion::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $questions;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function isShowOnHomepage(): bool
    {
        return $this->showOnHomepage;
    }

    public function setShowOnHomepage(bool $showOnHomepage): static
    {
        $this->showOnHomepage = $showOnHomepage;

        return $this;
    }

    public function getHomepageOrder(): int
    {
        return $this->homepageOrder;
    }

    public function setHomepageOrder(int $homepageOrder): static
    {
        $this->homepageOrder = $homepageOrder;

        return $this;
    }

    /**
     * @return Collection<int, TopicTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(TopicTranslation $translation): static
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setTopic($this);
        }

        return $this;
    }

    public function removeTranslation(TopicTranslation $translation): static
    {
        $this->translations->removeElement($translation);

        return $this;
    }

    /**
     * @return Collection<int, TopicQuestion>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(TopicQuestion $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setTopic($this);
        }

        return $this;
    }

    public function removeQuestion(TopicQuestion $question): static
    {
        $this->questions->removeElement($question);

        return $this;
    }
}
