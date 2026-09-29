<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\AI\Service\Generator\IndividualSpreadGeneratorService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\DTO\Input\IndividualSpreadDTO;

final class IndividualSpreadController extends AbstractController
{
    public function __construct(
        readonly private IndividualSpreadGeneratorService $service,
    ) {}

    #[Route('/api/individual-spread/{locale}', 'individual-spread', methods: ['POST'])]
    public function interpret(string $locale, #[MapRequestPayload] IndividualSpreadDTO $dto): JsonResponse
    {
        $result = $this->service->generate($locale, $dto);

        return new JsonResponse($result);
    }
}