<?php

namespace App\AI\Service;

use App\Exception\RetryableException;
use OpenAI\Client;
use OpenAI\Exceptions\{RateLimitException, ServerException, TransporterException};
use Psr\Log\LoggerInterface;

final class OpenAIClient
{
    private const int MAX_RETRIES = 3;

    public function __construct(
        private readonly Client $client,
        private readonly LoggerInterface $logger,
        private readonly string $model = 'gpt-5.6-luna',//gpt-4o-mini
    ) {}

    public function ask(array $messages): array
    {
        for ($attempt = 1; $attempt <= self::MAX_RETRIES; $attempt++) {
            $startedAt = microtime(true);

            try {
                $this->logger->info('OpenAI request started', [
                    'model' => $this->model,
                    'attempt' => $attempt,
                    'messages_count' => count($messages),
                ]);

                $response = $this->client->chat()->create([
                    'model' => $this->model,
                    'messages' => $messages,
                ]);

                $content = $response->choices[0]->message->content;

                if ($content === null) {
                    throw new \RuntimeException(
                        'OpenAI response does not contain message content'
                    );
                }

                $content = trim($content);

                $content = preg_replace(
                    '/^```(?:json)?\s*|\s*```$/i',
                    '',
                    $content
                );

                try {
                    $data = json_decode(
                        trim($content),
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    );
                } catch (\JsonException $e) {
                    $this->logger->error('OpenAI response is not valid JSON', [
                        'model' => $this->model,
                        'attempt' => $attempt,
                        'error' => $e->getMessage(),
                        'content' => $content,
                    ]);

                    throw new \RuntimeException(
                        'OpenAI response contains invalid JSON',
                        previous: $e
                    );
                }

                $this->logger->info('OpenAI request completed', [
                    'model' => $this->model,
                    'attempt' => $attempt,
                    'duration_seconds' => round(
                        microtime(true) - $startedAt,
                        3
                    ),
                ]);

                return $data;

            } catch (\Throwable $e) {
                $retryable = $this->isRetryable($e);

                $this->logger->error('OpenAI request failed', [
                    'model' => $this->model,
                    'attempt' => $attempt,
                    'retryable' => $retryable,
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                ]);

                if (!$retryable) {
                    throw $e;
                }

                if ($attempt === self::MAX_RETRIES) {
                    throw new RetryableException(
                        message: 'OpenAI temporary failure',
                        statusCode: 503,
                        retryAfterSeconds: 2,
                        context: [
                            'model' => $this->model,
                        ],
                    );
                }

                usleep(500_000 * $attempt);
            }
        }

        throw new \LogicException('Unreachable');
    }

    private function isRetryable(\Throwable $e): bool
    {
        return $e instanceof RateLimitException
            || $e instanceof ServerException
            || $e instanceof TransporterException;
    }
}