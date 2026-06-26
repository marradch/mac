<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\AI\Service\Interpreter\SpreadInterpreterService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\DTO\Input\SpreadDTO;

final class SpreadController extends AbstractController
{
    public function __construct(
        readonly private SpreadInterpreterService $service,
    ) {}

    #[Route('/api/spread/{locale}', 'spread', methods: ['POST'])]
    public function interpret(string $locale, #[MapRequestPayload] SpreadDTO $dto): JsonResponse
    {
        $result = $this->service->interpret($locale, $dto);

        return new JsonResponse($result);
    }
}
