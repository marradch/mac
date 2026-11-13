<?php

namespace App\Exception;

use RuntimeException;

class UserAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('User with this email already exists');
    }

    public function getStatusCode(): int
    {
        return 409;
    }

    public function getErrorCode(): string
    {
        return 'user_already_exists';
    }
}