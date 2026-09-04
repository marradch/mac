<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\EmotionAndCardDTO;
use App\DTO\Input\InterpretDTOInterface;

class EmotionAndCardMessagesBuilder implements InterpreterMessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        /** @var EmotionAndCardDTO $dto */

        $items = array_map(function ($item) {
            $state = $item['stateSlug'] ?? $item['state_slug'] ?? null;

            // Accept imageUrl at top level or inside `card` object
            $image = $item['imageUrl'] ?? $item['image_url'] ?? null;
            if (isset($item['card'])) {
                if (is_array($item['card'])) {
                    $image = $item['card']['imageUrl'] ?? $item['card']['image_url'] ?? $image;
                } elseif (is_object($item['card'])) {
                    $image = $item['card']->imageUrl ?? $item['card']->image_url ?? $image;
                }
            }

            return [
                'stateSlug' => $state,
                'card' => [
                    'image_url' => $image,
                ],
            ];
        }, $dto->cards);

        $payload = [
            'language' => $locale,
            'items' => $items,
        ];

        return [
            [
                'role' => 'system',
                'content' => file_get_contents(__DIR__ . '/../Prompt/emotion-and-card.md'),
            ],
            [
                'role' => 'user',
                'content' => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ],
        ];
    }
}
