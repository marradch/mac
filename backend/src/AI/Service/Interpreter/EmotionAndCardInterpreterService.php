<?php

namespace App\AI\Service\Interpreter;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\EmotionAndCardMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\InterpretDTOInterface;

class EmotionAndCardInterpreterService implements InterpreterInterface
{
    public function __construct(
        private EmotionAndCardMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) {}

    public function interpret(string $locale, InterpretDTOInterface $dto): array
    {
        // Convert each incoming item's card to MetaphoricalCard object
        $dto->cards = array_map(function ($item) {
            $image = $item['imageUrl'] ?? $item['image_url'] ?? null;

            return [
                'stateSlug' => $item['stateSlug'] ?? $item['state_slug'] ?? null,
                'card' => new MetaphoricalCard($image),
            ];
        }, $dto->cards);

        $messages = $this->messageBuilder->build($locale, $dto);

        return $this->openAIClient->ask($messages);
    }
}
