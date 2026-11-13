<?php

namespace App\DTO\Output;

final class LoginUserOutputDTO
{
    public function __construct(
        public readonly string $token,
        public readonly string $name,
        public readonly bool $hasSubscription,
    ) {
    }
}
