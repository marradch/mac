<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\AI\Service\Interpreter\ResourcesInterpreterService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\DTO\Input\ResourcesDTO;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

final class ResourcesController extends AbstractController {
    public function __construct(
        private ResourcesInterpreterService $resourcesService,
    ) {}

    #[Route('/api/resources/{locale}', 'resources', methods: ['POST', 'OPTIONS'])]
    public function list(string $locale, #[MapRequestPayload] ResourcesDTO $questionDTO, Request $request): JsonResponse
    {
        $result = $this->resourcesService->interpret(
            $locale,
            $questionDTO,
        );

        return new JsonResponse($result);
    }
}
