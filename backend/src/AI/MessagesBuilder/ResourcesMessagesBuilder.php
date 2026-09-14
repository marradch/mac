<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

class ResourcesMessagesBuilder extends AbstractInterpreterMessagesBuilder
{
    protected string $promptFilename = 'resources.md';

    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => $this->loadPrompt()
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
