<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

final class LoginUserDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Email is required')]
        #[Assert\Email(message: 'Email is invalid')]
        public ?string $email,

        #[Assert\NotBlank(message: 'Password is required')]
        #[Assert\Length(min: 8, minMessage: 'Password must be at least 8 characters long')]
        public ?string $password,
    ) {
        $this->email = mb_strtolower(trim((string) $email));
    }
}
