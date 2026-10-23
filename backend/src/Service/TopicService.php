<?php

namespace App\Service;

use App\DTO\Output\TopicOutputDTO;
use App\Factory\TopicOutputDTOFactory;
use App\Repository\TopicRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TopicService
{
    public function __construct(
        private readonly TopicRepository $topicRepository,
        private readonly TopicOutputDTOFactory $topicOutputDTOFactory,
    ) {
    }

    /** @return list<\App\Entity\Topic> */
    public function findAllForHomepageByLocale(string $locale): array
    {
        return $this->topicRepository->findAllForHomepageByLocale($locale);
    }

    public function findOneBySlugAndLocale(string $slug, string $locale): TopicOutputDTO
    {
        $topic = $this->topicRepository->findOneBySlugAndLocale($slug, $locale);

        if ($topic === null) {
            throw new NotFoundHttpException(sprintf('Topic "%s" not found', $slug));
        }

        return $this->topicOutputDTOFactory->makeTopicPageOutputDTO($topic);
    }
}
