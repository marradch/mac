<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\AI\Service\Interpreter\TimeSpreadInterpreterService;
use App\Factory\TimeSpreadCardsFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\DTO\Input\TimeSpreadDTO;

final class TimeSpreadController extends AbstractController
{
    public function __construct(
        private TimeSpreadInterpreterService $service
    ) {}

    #[Route('/api/time-spread/{locale}', 'time_spread', methods: ['POST', 'OPTIONS'])]
    public function interpret(string $locale, #[MapRequestPayload] TimeSpreadDTO $timeSpreadDTO, Request $request): JsonResponse
    {
        $result = $this->service->interpret($locale, $timeSpreadDTO);

        return new JsonResponse($result);
    }
}
