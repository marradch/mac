<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\EmotionAndCardDTO;
use App\DTO\Input\InterpretDTOInterface;

class EmotionAndCardMessagesBuilder extends AbstractInterpreterMessagesBuilder
{
    protected string $promptFilename = 'emotion-and-card.md';

    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        /** @var EmotionAndCardDTO $dto */

        $content = [];

        $content[] = [
            'type' => 'text',
            'text' => "LANGUAGE: {$locale}",
        ];

        foreach ($dto->cards as $index => $item) {
            $state = $item['stateSlug'] ?? $item['state_slug'] ?? null;

            $image = $item['imageUrl'] ?? $item['image_url'] ?? null;

            if (isset($item['card'])) {
                if (is_array($item['card'])) {
                    $image = $item['card']['imageUrl']
                        ?? $item['card']['image_url']
                        ?? $image;
                } elseif (is_object($item['card'])) {
                    $image = $item['card']->imageUrl
                        ?? $item['card']->image_url
                        ?? $image;
                }
            }

            $num = $index + 1;

            $content[] = [
                'type' => 'text',
                'text' => "card {$num}\nSTATE SLUG: {$state}",
            ];

            $content[] = [
                'type' => 'image_url',
                'image_url' => [
                    'url' => $image,
                ],
            ];
        }

        return [
            [
                'role' => 'system',
                'content' => $this->loadPrompt(),
            ],
            [
                'role' => 'user',
                'content' => $content,
            ],
        ];
    }
}
