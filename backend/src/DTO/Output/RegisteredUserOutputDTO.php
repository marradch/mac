<?php

namespace App\DTO\Output;

final class RegisteredUserOutputDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
    ) {
    }
}
