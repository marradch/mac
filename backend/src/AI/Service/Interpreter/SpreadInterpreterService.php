<?php

namespace App\AI\Service\Interpreter;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\SpreadMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\InterpretDTOInterface;

class SpreadInterpreterService implements InterpreterInterface
{
    public function __construct(
        private SpreadMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) { }

    public function interpret(string $locale, InterpretDTOInterface $dto): array
    {
        $messages = $this->messageBuilder->build($locale, $dto);

        return $this->openAIClient->ask($messages);
    }
}
