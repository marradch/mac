<?php

namespace App\AI\Service\Interpreter;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\QuestionToCardMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\QuestionToCardDTO;

class QuestionToCardInterpreterService implements InterpreterInterface
{
    public function __construct(
        private QuestionToCardMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) { }

    public function interpret(string $locale, object $dto): array
    {
        /** @var QuestionToCardDTO $dto */
        
        $dto->cards = array_map(
            fn($card) => new MetaphoricalCard($card['imageUrl']),
            $dto->cards
        );

        $messages = $this->messageBuilder->build($locale, $dto);

        return $this->openAIClient->ask($messages);
    }
}
