<?php

namespace App\Service;

use App\DTO\Input\LoginUserDTO;
use App\DTO\Input\RegisterUserDTO;
use App\DTO\Output\LoginUserOutputDTO;
use App\DTO\Output\RegisteredUserOutputDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AuthService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly JWTTokenManagerInterface $jwtManager,
    ) {
    }

    /**
     * @return RegisteredUserOutputDTO
     */
    public function register(RegisterUserDTO $dto): RegisteredUserOutputDTO
    {
        $name = $dto->name;
        $email = $dto->email;

        if ($this->userRepository->findOneBy(['email' => $email]) !== null) {
            throw new ConflictHttpException('User with this email already exists');
        }

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $dto->password));
        $user->setVerificationToken(bin2hex(random_bytes(32)));
        $user->setVerificationTokenExpiresAt(new \DateTimeImmutable('+1 day'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new RegisteredUserOutputDTO(
            (int) $user->getId(),
            $user->getName(),
            $user->getEmail(),
        );
    }

    public function login(LoginUserDTO $dto): LoginUserOutputDTO
    {
        $user = $this->userRepository->findOneBy(['email' => $dto->email]);

        if (
            $user === null
            || !$this->passwordHasher->isPasswordValid($user, (string) $dto->password)
        ) {
            throw new UnauthorizedHttpException('basic', 'Invalid credentials');
        }

        if (!$user->isEmailVerified()) {
            throw new BadRequestHttpException('Please verify your email first.');
        }

        $hasSubscription = $this->hasActiveSubscription($user);
        $token = $this->jwtManager->create($user);

        return new LoginUserOutputDTO(
            $token,
            $user->getName() ?? '',
            $hasSubscription,
        );
    }

    private function hasActiveSubscription(User $user): bool
    {
        $expiresAt = $user->getSubscriptionExpiresAt();

        if ($expiresAt === null) {
            return false;
        }

        return $expiresAt > new \DateTimeImmutable();
    }
}
