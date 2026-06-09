<?php

namespace App\AI\Service\Interpreter;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\ResourcesMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\InterpretDTOInterface;

class ResourcesInterpreterService implements InterpreterInterface
{
    public function __construct(
        private ResourcesMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) { }

    public function interpret(string $locale, InterpretDTOInterface $dto): array
    {
        $dto->cards = array_map(
            fn($card) => new MetaphoricalCard($card['imageUrl']),
            $dto->cards
        );

        $messages = $this->messageBuilder->build($locale, $dto);

        return $this->openAIClient->ask($messages);
    }
}
