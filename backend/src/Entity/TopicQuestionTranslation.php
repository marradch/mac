<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'topic_question_translation')]
#[ORM\UniqueConstraint(name: 'uniq_topic_question_locale', columns: ['topic_question_id', 'locale'])]
class TopicQuestionTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: TopicQuestion::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(
        name: 'topic_question_id',
        referencedColumnName: 'id',
        nullable: false,
        onDelete: 'CASCADE'
    )]
    private TopicQuestion $question;

    #[ORM\Column(length: 10)]
    private string $locale;

    #[ORM\Column(type: Types::TEXT)]
    private string $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): TopicQuestion
    {
        return $this->question;
    }

    public function setQuestion(TopicQuestion $question): static
    {
        $this->question = $question;

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

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }
}
