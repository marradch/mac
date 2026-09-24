<?php

namespace App\AI\Service;

use App\Exception\RetryableException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAIClient
{
    private const string API_URL = 'https://api.openai.com/v1/chat/completions';

    private string $model = 'gpt-5.6-luna';
    // private string $model = 'gpt-4o-mini';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey,
        private LoggerInterface $logger,
    ) {}

    public function ask(array $messages): array
    {
        $maxRetries = 3;

        for ($i = 0; $i < $maxRetries; $i++) {
            $attempt = $i + 1;
            $startedAt = microtime(true);

            $this->logger->info('OpenAI request started', [
                'model' => $this->model,
                'attempt' => $attempt,
                'max_retries' => $maxRetries,
                'messages_count' => count($messages),
            ]);

            try {
                $response = $this->httpClient->request(
                    'POST',
                    self::API_URL,
                    [
                        'timeout' => 60,

                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->apiKey,
                            'Content-Type' => 'application/json',
                        ],

                        'json' => [
                            'model' => $this->model,
                            'messages' => $messages,
                        ],
                    ]
                );

                // ВАЖНО: false не выбрасывает exception на 4xx/5xx
                $rawResponse = $response->getContent(false);

                $statusCode = $response->getStatusCode();

                $duration = round(
                    microtime(true) - $startedAt,
                    3
                );

                $this->logger->info('OpenAI response received', [
                    'model' => $this->model,
                    'attempt' => $attempt,
                    'status' => $statusCode,
                    'duration_seconds' => $duration,
                    'response_length' => strlen($rawResponse),
                ]);

                // Если OpenAI вернул 4xx/5xx
                if ($statusCode >= 400) {
                    $this->logger->error('OpenAI returned HTTP error', [
                        'model' => $this->model,
                        'attempt' => $attempt,
                        'status' => $statusCode,
                        'duration_seconds' => $duration,
                        'response' => $rawResponse,
                    ]);

                    throw new \RuntimeException(
                        sprintf(
                            'OpenAI HTTP %d: %s',
                            $statusCode,
                            $rawResponse
                        )
                    );
                }

                $responseData = json_decode($rawResponse, true);

                if (!is_array($responseData)) {
                    $this->logger->error('OpenAI content is not valid JSON', [
                        'model' => $this->model,
                        'attempt' => $attempt,
                        'json_error' => json_last_error_msg(),
                        'content_preview' => mb_substr($clean, 0, 1000),
                    ]);

                    throw new \RuntimeException(
                        'Invalid OpenAI response JSON: ' . json_last_error_msg()
                    );
                }

                $raw = $responseData['choices'][0]['message']['content']
                    ?? null;

                if ($raw === null) {
                    $this->logger->error('OpenAI response has no content', [
                        'model' => $this->model,
                        'attempt' => $attempt,
                        'response' => $rawResponse,
                    ]);

                    throw new \RuntimeException(
                        'OpenAI response does not contain choices[0].message.content'
                    );
                }

                $clean = preg_replace('/^```json|```$/m', '', $raw);
                $clean = trim($clean);

                $data = json_decode($clean, true);

                $this->logger->info('OpenAI request completed successfully', [
                    'model' => $this->model,
                    'attempt' => $attempt,
                    'duration_seconds' => $duration,
                ]);

                return $data;

            } catch (\Throwable $e) {

                $duration = round(
                    microtime(true) - $startedAt,
                    3
                );

                $message = $e->getMessage();

                $retryable =
                    str_contains($message, 'Connection reset') ||
                    str_contains($message, 'timeout') ||
                    str_contains($message, 'cURL error') ||
                    str_contains($message, '502') ||
                    str_contains($message, '503') ||
                    str_contains($message, '504') ||
                    str_contains($message, '429');

                $this->logger->error('OpenAI request failed', [
                    'model' => $this->model,
                    'attempt' => $attempt,
                    'duration_seconds' => $duration,
                    'retryable' => $retryable,
                    'exception_class' => get_class($e),
                    'message' => $message,
                ]);

                if (!$retryable) {
                    throw $e;
                }

                if ($attempt === $maxRetries) {
                    $this->logger->error(
                        'OpenAI request failed after all retries',
                        [
                            'model' => $this->model,
                            'attempts' => $maxRetries,
                        ]
                    );

                    throw new RetryableException(
                        message: 'OpenAI temporary failure',
                        statusCode: 503,
                        retryAfterSeconds: 2,
                        context: [
                            'model' => $this->model,
                        ]
                    );
                }

                $sleep = 500000 * $attempt;

                $this->logger->warning('Retrying OpenAI request', [
                    'model' => $this->model,
                    'attempt' => $attempt,
                    'next_attempt' => $attempt + 1,
                    'sleep_microseconds' => $sleep,
                ]);

                usleep($sleep);
            }
        }

        throw new \RuntimeException(
            'OpenAI request failed after retries'
        );
    }
}