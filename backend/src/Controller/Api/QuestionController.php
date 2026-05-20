<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\AI\Service\QuestionToCardService;
use App\AI\DTO\MetaphoricalCard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\DTO\Input\QuestionDTO;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

final class QuestionController extends AbstractController {
    public function __construct(
        private QuestionToCardService $questionToCardService,
    ) {}

    #[Route('/api/question/{locale}', 'question_to_card', methods: ['POST', 'OPTIONS'])]
    public function list(string $locale, #[MapRequestPayload] QuestionDTO $questionDTO, Request $request): JsonResponse
    {
        if ($request->getMethod() === 'OPTIONS') {
            return new JsonResponse(null, 204, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type',
            ]);
        }

        $card = new MetaphoricalCard($questionDTO->cardUrl);

        $result = $this->questionToCardService->interpret(
            $locale,
            $questionDTO->query,
            $card
        );

        return new JsonResponse($result);
    }
}
