<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\AI\Service\Interpreter\EmotionAndCardInterpreterService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\DTO\Input\EmotionAndCardDTO;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

final class EmotionAndCardController extends AbstractController {
    public function __construct(
        private readonly EmotionAndCardInterpreterService $service,
    ) {}

    #[Route('/api/emotion-and-card/{locale}', 'emotion_and_card', methods: ['POST'])]
    public function handle(string $locale, #[MapRequestPayload] EmotionAndCardDTO $dto): JsonResponse
    {
        $result = $this->service->interpret($locale, $dto);

        return new JsonResponse($result);
    }
}
