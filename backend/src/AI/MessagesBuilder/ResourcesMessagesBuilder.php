<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\ResourcesDTO;

class ResourcesMessagesBuilder extends AbstractMessagesBuilder
{
    protected string $promptFilename = 'resources.md';

    protected bool $hasMeditation = true;

    public function build(string $locale, object $dto): array
    {
        /** @var ResourcesDTO $dto */
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

    private function buildCardsContent(string $locale, object $dto): array
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
