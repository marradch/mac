<?php

namespace App\AI\Service\Generator;

use App\AI\DTO\MetaphoricalCard;
use App\AI\MessagesBuilder\IndividualSpreadMessagesBuilder;
use App\AI\Service\OpenAIClient;
use App\DTO\Input\IndividualSpreadDTO;

class IndividualSpreadGeneratorService
{
    public function __construct(
        private IndividualSpreadMessagesBuilder $messageBuilder,
        private OpenAIClient $openAIClient
    ) {}
    public function generate(string $locale, IndividualSpreadDTO $dto): array
    {
        $messages = $this->messageBuilder->build($locale, $dto);

        return $this->openAIClient->ask($messages);
    }
}