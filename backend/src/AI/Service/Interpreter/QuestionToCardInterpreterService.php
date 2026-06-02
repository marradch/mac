<?php

namespace App\AI\Service\Interpreter;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\QuestionToCardMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\InterpretDTOInterface;

class QuestionToCardInterpreterService implements InterpreterInterface
{
    public function __construct(
        private QuestionToCardMessagesBuilder $messageBuilder,
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
