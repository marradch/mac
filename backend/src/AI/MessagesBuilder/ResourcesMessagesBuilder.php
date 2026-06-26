<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

class ResourcesMessagesBuilder implements MessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => file_get_contents(__DIR__ . '/../Prompt/resources.md')
            ],
            [
                'role' => 'user',
                'content' => $this->buildCardsContent($locale, $dto)
            ]
        ];
    }

    private function buildCardsContent(string $locale, InterpretDTOInterface $dto): array
    {
        $result = [];

        $result[] = [
            'type' => 'text',
            'text' => "LANGUAGE: {$locale}",
        ];

        $result[] = [
            'type' => 'text',
            'text' => $dto->query
        ];

        foreach ($dto->cards as $index => $card) {
            $num = $index + 1;

            $result[] = [
                'type' => 'text',
                'text' => "card {$num}",
            ];

            $result[] = [
                'type' => 'image_url',
                'image_url' => [
                    'url' => $card->imageUrl,
                ],
            ];
        }

        return $result;
    }
}
