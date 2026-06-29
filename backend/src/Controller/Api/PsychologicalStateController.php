<?php

namespace App\Controller\Api;

use App\Factory\PsychologicalStateOutputDTOFactory;
use App\Service\PsychologicalStateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PsychologicalStateController extends AbstractController
{
    public function __construct(
        private PsychologicalStateService $service,
        private PsychologicalStateOutputDTOFactory $factory
    ) {}

    #[Route('/api/psychological-states/{locale}', 'api_psychological_states_list', methods: ['GET'])]
    public function list(string $locale): JsonResponse
    {
        $states = $this->service->findAllByLocale($locale);
        $dtos = $this->factory->makePsychologicalStateOutputDTOs($states);

        return $this->json($dtos);
    }
}
