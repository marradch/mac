<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\AI\Service\QuestionToCardService;
use App\AI\DTO\MetaphoricalCard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class QuestionController extends AbstractController {
    public function __construct(
        private QuestionToCardService $questionToCardService,
    ) {}

    #[Route('/api/question/{locale}', 'question_to_card', methods: ['POST', 'OPTIONS'])]
    public function list(string $locale, Request $request): JsonResponse
    {
        if ($request->getMethod() === 'OPTIONS') {
            return new JsonResponse(null, 204, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type',
            ]);
        }

        $data = json_decode($request->getContent(), true);
        $card = new MetaphoricalCard($data['cardUrl']);

        $result = $this->questionToCardService->interpret(
            $locale,
            $data['query'],
            $card
        );

        return new JsonResponse($result);
    }
}
