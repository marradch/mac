<?php

namespace App\AI\Service;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\QuestionToCardMessagesBuilder;
use App\AI\Service\OpenAIClient;

class QuestionToCardService {
    public function __construct(
        private QuestionToCardMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) { }

    public function interpret(string $locale, string $query, MetaphoricalCard $card)
    {
        $messages = $this->messageBuilder->buildMessages($locale, $query, $card);

        return $this->openAIClient->ask($messages);
    }
}
