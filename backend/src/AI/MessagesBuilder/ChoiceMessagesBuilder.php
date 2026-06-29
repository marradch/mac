<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\{ChoiceDTO, InterpretDTOInterface};

class ChoiceMessagesBuilder implements InterpreterMessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => file_get_contents(__DIR__ . '/../Prompt/choice.md'),
            ],
            [
                'role' => 'user',
                'content' => json_encode(
                    $this->buildPayload($dto, $locale),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                ),
            ],
        ];
    }

    private function buildPayload(ChoiceDTO $dto, string $locale): array
    {
        $payload = [
            'language' => $locale,
            'query' => $dto->query,
            'option1' => [
                'text' => $dto->option1Text,
                'cards' => $this->mapCards($dto->option1Cards),
            ],
            'option2' => [
                'text' => $dto->option2Text,
                'cards' => $this->mapCards($dto->option2Cards),
            ],
        ];

        return $payload;
    }

    private function mapCards(array $cards): array
    {
        return array_map(function ($card, $index) {
            return [
                'number' => $index + 1,
                'image_url' => $card->imageUrl,
            ];
        }, $cards, array_keys($cards));
    }
}
