<?php

namespace App\AI\Service;

use App\AI\MessagesBuilder\TimeSpreadMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\Factory\TimeSpreadCardsFactory;
use App\DTO\Input\InterpretDTOInterface;

class TimeSpreadService implements InterpreterInterface
{
    public function __construct(
        private TimeSpreadMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient,
        private TimeSpreadCardsFactory $cardsFactory
    ) {}

    public function interpret(string $locale, InterpretDTOInterface $dto): array
    {
        $cards = $this->cardsFactory->makeTimeSpreadCardsArray($dto);

        $messages = $this->messageBuilder->buildMessages(
            $locale,
            $dto->query,
            $cards
        );

        return $this->openAIClient->ask($messages);
    }
}
