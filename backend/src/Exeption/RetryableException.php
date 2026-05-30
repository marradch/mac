<?php

namespace App\Exception;

use RuntimeException;

class RetryableException extends RuntimeException
{
    public function __construct(
        string $message = 'Temporary error, request can be retried',
        private readonly int $statusCode = 503,
        private readonly ?int $retryAfterSeconds = null,
        private readonly array $context = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getRetryAfterSeconds(): ?int
    {
        return $this->retryAfterSeconds;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
