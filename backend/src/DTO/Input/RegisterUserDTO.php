<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

final class RegisterUserDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Name is required')]
        #[Assert\Length(min: 2, max: 255, minMessage: 'Name must be at least 2 characters long', maxMessage: 'Name cannot be longer than 255 characters')]
        public ?string $name,

        #[Assert\NotBlank(message: 'Email is required')]
        #[Assert\Email(message: 'Email is invalid')]
        public ?string $email,

        #[Assert\NotBlank(message: 'Password is required')]
        #[Assert\Length(min: 8, minMessage: 'Password must be at least 8 characters long')]
        public ?string $password,
    ) {
        $this->name = trim((string) $name);
        $this->email = mb_strtolower(trim((string) $email));
    }
}
