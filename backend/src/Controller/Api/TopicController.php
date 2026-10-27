<?php

namespace App\Controller\Api;

use App\Factory\TopicOutputDTOFactory;
use App\Service\TopicService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class TopicController extends AbstractController
{
    public function __construct(
        private readonly TopicService $topicService,
        private readonly TopicOutputDTOFactory $topicOutputDTOFactory,
    ) {
    }

    #[Route('/api/topics-home/{locale}', 'api_topics_list', methods: ['GET'])]
    public function list(string $locale): JsonResponse
    {
        $topics = $this->topicService->findAllForHomepageByLocale($locale);
        $dtos = $this->topicOutputDTOFactory->makeTopicOutputDTOs($topics);

        return $this->json($dtos);
    }

    #[Route('/api/topics/{locale}/{slug}', 'api_topic', methods: ['GET'])]
    public function show(string $locale, string $slug): JsonResponse
    {
        $dto = $this->topicService->findOneBySlugAndLocale($slug, $locale);

        return $this->json($dto);
    }
}
