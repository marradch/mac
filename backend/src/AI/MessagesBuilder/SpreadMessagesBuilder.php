<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

class SpreadMessagesBuilder implements InterpreterMessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => file_get_contents(__DIR__ . '/../Prompt/spread.md')
            ],
            [
                'role' => 'user',
                'content' => json_encode($this->buildPayload($dto, $locale), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ]
        ];
    }

    private function buildPayload(InterpretDTOInterface $dto, string $locale): array
    {
        return [
            'language' => $locale,
            'query' => $dto->query,
            'cards' => array_map(function ($card) {
                return [
                    'title' => $card->title,
                    'slug' => $card->slug,
                    'image_url' => $card->imageUrl,
                ];
            }, $dto->cards)
        ];
    }
}
