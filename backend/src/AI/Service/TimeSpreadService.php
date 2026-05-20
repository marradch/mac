<?php

namespace App\AI\Service;

use App\AI\MessagesBuilder\TimeSpreadMessagesBuilder;
use App\AI\Service\OpenAIClient;

class TimeSpreadService
{
    public function __construct(
        private TimeSpreadMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) {}

    /**
     * @param string $locale
     * @param string $query
     * @param array{
     *     past: array,
     *     present: array,
     *     future: array
     * } $cards
     */
    public function interpret(string $locale, string $query, array $cards): array
    {
        $messages = $this->messageBuilder->buildMessages(
            $locale,
            $query,
            $cards
        );

        return $this->openAIClient->ask($messages);
    }
}
