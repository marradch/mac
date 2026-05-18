<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ExerciseService;
use App\Factory\ExerciseOutputDTOFactory;

final class ExerciseController extends AbstractController
{
    public function __construct(
        private ExerciseService $service,
        private ExerciseOutputDTOFactory $factory
    ) {}

    #[Route('/api/exercises/{locale}', 'api_exercises_list', methods: ['GET'])]
    public function list(string $locale): JsonResponse
    {
        $exercises = $this->service->findAllByLocale($locale);
        $dtos = $this->factory->makeExerciseOutputDTOs($exercises);

        return $this->json($dtos);
    }

    #[Route('/api/exercises/{locale}/{slug}', 'api_exercise', methods: ['GET'])]
    public function show(string $locale, string $slug): JsonResponse
    {
        $exercise = $this->service->findOneBySlugAndLocale($locale, $slug);
        $dto = $this->factory->makeExerciseOutputDTOForExercisePage($exercise);

        return $this->json($dto);
    }
}

