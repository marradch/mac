<?php

namespace App\AI\Service\Interpreter;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\TimeSpreadMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\TimeSpreadDTO;

class TimeSpreadInterpreterService implements InterpreterInterface
{
    public function __construct(
        private TimeSpreadMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) {}

    public function interpret(string $locale, object $dto): array
    {
        /** @var TimeSpreadDTO $dto */
        
        foreach (['past', 'present', 'future'] as $timeRange) {
            $optionCards = $dto->{$timeRange};

            $dto->{$timeRange} = array_map(
                fn($card) => new MetaphoricalCard($card['imageUrl']),
                $optionCards
            );
        }

        $messages = $this->messageBuilder->build($locale, $dto);

        return $this->openAIClient->ask($messages);
    }
}
