<?php

namespace App\Factory;

use App\DTO\Output\TopicOutputDTO;
use App\Entity\Topic;
use App\Entity\TopicQuestion;

class TopicOutputDTOFactory
{
    public function makeTopicOutputDTO(Topic $topic): TopicOutputDTO
    {
        $translation = $topic->getTranslations()->first();

        $dto = new TopicOutputDTO();
        $dto->slug = $topic->getSlug();
        $dto->title = $translation?->getTitle();
        $dto->showOnHomepage = $topic->isShowOnHomepage();

        return $dto;
    }

    /**
     * @param list<Topic> $topics
     * @return list<TopicOutputDTO>
     */
    public function makeTopicOutputDTOs(array $topics): array
    {
        return array_map(
            fn (Topic $topic): TopicOutputDTO => $this->makeTopicOutputDTO($topic),
            $topics
        );
    }

    public function makeTopicHomeOutputDTO(Topic $topic): TopicOutputDTO
    {
        $translation = $topic->getTranslations()->first();

        $dto = new TopicOutputDTO();
        $dto->slug = $topic->getSlug();
        $dto->title = $translation?->getTitle();

        return $dto;
    }

    /**
     * @param list<Topic> $topics
     * @return list<TopicOutputDTO>
     */
    public function makeTopicHomeOutputDTOs(array $topics): array
    {
        return array_map(
            fn (Topic $topic): TopicOutputDTO => $this->makeTopicHomeOutputDTO($topic),
            $topics
        );
    }

    public function makeTopicPageOutputDTO(Topic $topic): TopicOutputDTO
    {
        $translation = $topic->getTranslations()->first();

        $dto = new TopicOutputDTO();
        $dto->id = $topic->getId();
        $dto->slug = $topic->getSlug();
        $dto->title = $translation?->getTitle();
        $dto->description = $translation?->getDescription();
        $dto->seoTitle = $translation?->getSeoTitle();
        $dto->seoDescription = $translation?->getSeoDescription();
        $dto->showOnHomepage = $topic->isShowOnHomepage();
        $dto->questions = array_map(
            static function (TopicQuestion $question): array {
                $translation = $question->getTranslations()->first();

                return [
                    'slug' => $question->getSlug(),
                    'text' => $translation?->getText(),
                ];
            },
            $topic->getQuestions()->toArray()
        );

        return $dto;
    }
}
