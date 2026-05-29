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
        $card = new MetaphoricalCard($dto->cardUrl);
        $messages = $this->messageBuilder->buildMessages($locale, $dto->query, $card);

        return $this->openAIClient->ask($messages);
    }
}
