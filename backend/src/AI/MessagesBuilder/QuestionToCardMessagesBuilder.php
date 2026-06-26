<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

class QuestionToCardMessagesBuilder implements MessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => file_get_contents(__DIR__ . '/../Prompt/question.md')
            ],
            [
                'role' => 'user',
                'content' => json_encode(
                    $this->buildPayload($dto, $locale),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                )
            ]
        ];
    }

    private function buildPayload(InterpretDTOInterface $dto, string $locale): array
    {
        return [
            'language' => $locale,
            'query' => $dto->query,
            'cards' => array_map(function ($card, $index) {
                return [
                    'number' => $index + 1,
                    'image_url' => $card->imageUrl,
                ];
            }, $dto->cards, array_keys($dto->cards)),
        ];
    }
}
