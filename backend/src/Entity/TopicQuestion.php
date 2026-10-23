<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'topic_question')]
#[ORM\UniqueConstraint(name: 'uniq_topic_question_slug', columns: ['topic_id', 'slug'])]
class TopicQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Topic::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Topic $topic;

    #[ORM\Column(length: 120)]
    private string $slug;

    /**
     * @var Collection<int, TopicQuestionTranslation>
     */
    #[ORM\OneToMany(
        mappedBy: 'question',
        targetEntity: TopicQuestionTranslation::class,
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

    public function getTopic(): Topic
    {
        return $this->topic;
    }

    public function setTopic(Topic $topic): static
    {
        $this->topic = $topic;

        return $this;
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

    /**
     * @return Collection<int, TopicQuestionTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(TopicQuestionTranslation $translation): static
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setQuestion($this);
        }

        return $this;
    }

    public function removeTranslation(TopicQuestionTranslation $translation): static
    {
        $this->translations->removeElement($translation);

        return $this;
    }
}
