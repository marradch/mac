<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'topic_translation')]
#[ORM\UniqueConstraint(name: 'uniq_topic_locale', columns: ['topic_id', 'locale'])]
class TopicTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Topic::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Topic $topic;

    #[ORM\Column(length: 10)]
    private string $locale;

    #[ORM\Column(length: 200)]
    private string $title;

    #[ORM\Column(name: 'seo_title', length: 500)]
    private string $seoTitle;

    #[ORM\Column(name: 'seo_description', length: 500)]
    private string $seoDescription;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

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

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSeoTitle(): string
    {
        return $this->seoTitle;
    }

    public function setSeoTitle(string $seoTitle): static
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    public function getSeoDescription(): string
    {
        return $this->seoDescription;
    }

    public function setSeoDescription(string $seoDescription): static
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
