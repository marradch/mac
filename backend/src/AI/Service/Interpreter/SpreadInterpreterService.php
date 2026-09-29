<?php

namespace App\AI\Service\Interpreter;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\SpreadMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\SpreadDTO;

class SpreadInterpreterService implements InterpreterInterface
{
    public function __construct(
        private SpreadMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) { }

    public function interpret(string $locale, object $dto): array
    {
        /** @var SpreadDTO $dto */
        $messages = $this->messageBuilder->build($locale, $dto);

        return $this->openAIClient->ask($messages);
    }
}
