<?php

namespace App\Controller\Api;

use App\AI\Service\QuestionToCardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\AI\Service\TimeSpreadService;
use App\Factory\TimeSpreadCardsFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\DTO\Input\TimeSpreadDTO;

final class TimeSpreadController extends AbstractController
{
    public function __construct(
        private TimeSpreadService $service,
        private TimeSpreadCardsFactory $factory
    ) {}

    #[Route('/api/time-spread/{locale}', 'time_spread', methods: ['POST', 'OPTIONS'])]
    public function interpret(string $locale, #[MapRequestPayload] TimeSpreadDTO $timeSpreadDTO, Request $request)
    {
        $cards = $this->factory->makeTimeSpreadCardsArray($timeSpreadDTO);

        $result = $this->service->interpret($locale, $timeSpreadDTO->query, $cards);

        return new JsonResponse($result);
    }
}
