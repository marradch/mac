<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\AI\Service\Interpreter\QuestionToCardInterpreterService;
use App\AI\DTO\MetaphoricalCard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\DTO\Input\QuestionDTO;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

final class QuestionController extends AbstractController {
    public function __construct(
        private readonly QuestionToCardInterpreterService $questionToCardService,
    ) {}

    #[Route('/api/question/{locale}', 'question_to_card', methods: ['POST'])]
    public function list(string $locale, #[MapRequestPayload] QuestionDTO $questionDTO): JsonResponse
    {
        $result = $this->questionToCardService->interpret(
            $locale,
            $questionDTO,
        );

        return new JsonResponse($result);
    }
}
