<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\AI\Service\Interpreter\ChoiceInterpreterService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\DTO\Input\ChoiceDTO;

final class ChoiceController extends AbstractController
{
    public function __construct(
        private ChoiceInterpreterService $service,
    ) {}

    #[Route('/api/choice/{locale}', 'choice', methods: ['POST', 'OPTIONS'])]
    public function interpret(string $locale, #[MapRequestPayload] ChoiceDTO $dto, Request $request): JsonResponse
    {
        $result = $this->service->interpret($locale, $dto);

        return new JsonResponse($result);
    }
}
