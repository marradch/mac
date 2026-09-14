<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

class SpreadMessagesBuilder extends AbstractInterpreterMessagesBuilder
{
    protected string $promptFilename = 'spread.md';

    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        $content = [
            [
                'type' => 'text',
                'text' => "LANGUAGE: {$locale}",
            ],
            [
                'type' => 'text',
                'text' => "QUERY: {$dto->query}",
            ],
        ];

        foreach ($dto->cards as $index => $card) {
            $num = $index + 1;

            $content[] = [
                'type' => 'text',
                'text' => "CARD {$card->slug}",
            ];

            $content[] = [
                'type' => 'text',
                'text' => "TITLE: {$card->title}",
            ];

            $content[] = [
                'type' => 'image_url',
                'image_url' => [
                    'url' => $card->imageUrl,
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

