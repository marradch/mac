<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\DeckService;
use App\Factory\DeckOutputDTOFactory;

final class DeckController extends AbstractController
{
    public function __construct(
        private DeckService $service,
        private DeckOutputDTOFactory $factory
    ) {}

    #[Route('/api/decks/{locale}', 'api_decks_list', methods: ['GET'])]
    public function list(string $locale): JsonResponse
    {
        $decks = $this->service->findAllByLocale($locale);
        $dtos = $this->factory->makeDeckOutputDTOs($decks);

        return $this->json($dtos);
    }
}
