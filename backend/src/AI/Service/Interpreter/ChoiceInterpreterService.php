<?php

namespace App\AI\Service\Interpreter;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\ChoiceMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\InterpretDTOInterface;

class ChoiceInterpreterService implements InterpreterInterface
{
    public function __construct(
        private ChoiceMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) {}

    public function interpret(string $locale, InterpretDTOInterface $dto): array
    {
        foreach (['option1Cards', 'option2Cards'] as $option) {
            $optionCards = $dto->{$option};
            $newOptionCards = [];
            foreach ($optionCards as $card) {
                $newOptionCards[] = new MetaphoricalCard($card['imageUrl']);
            }
            $dto->{$option} = $newOptionCards;
        }

        $messages = $this->messageBuilder->build($locale, $dto);

        return $this->openAIClient->ask($messages);
    }
}
