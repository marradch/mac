<?php

namespace App\Controller\Api;

use App\DTO\Input\LoginUserDTO;
use App\DTO\Input\RegisterUserDTO;
use App\DTO\Output\LoginUserOutputDTO;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    #[Route('/api/auth/register', 'api_auth_register', methods: ['POST'])]
    public function register(#[MapRequestPayload] RegisterUserDTO $dto): JsonResponse
    {
        $this->authService->register($dto);

        return $this->json(['status' =>'success'], 201);
    }

    #[Route('/api/auth/login', 'api_auth_login', methods: ['POST'])]
    public function login(#[MapRequestPayload] LoginUserDTO $dto): JsonResponse
    {
        /** @var LoginUserOutputDTO $loginOutputDTO */
        $loginOutputDTO = $this->authService->login($dto);

        return $this->json($loginOutputDTO, 200);
    }
}
