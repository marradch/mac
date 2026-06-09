<?php

namespace App\AI\MessagesBuilder;

use App\AI\Prompt\ResourcesExercisePrompt;
use App\DTO\Input\InterpretDTOInterface;

class ResourcesMessagesBuilder implements MessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => ResourcesExercisePrompt::$prompt[$locale]
            ],
            [
                'role' => 'user',
                'content' => $this->buildCardsContent($dto)
            ]
        ];
    }

    private function buildCardsContent(InterpretDTOInterface $dto): array
    {
        $result = [];

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
