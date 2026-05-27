<?php

namespace App\AI\MessagesBuilder;

use App\AI\Prompt\ChoiceExercisePrompt;
use App\DTO\Input\{ChoiceDTO, InterpretDTOInterface};

class ChoiceMessagesBuilder
{
    public function buildMessages(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => ChoiceExercisePrompt::$prompt[$locale],
            ],
            [
                'role' => 'user',
                'content' => $this->buildUserContent($dto),
            ],
        ];
    }

    private function buildUserContent(ChoiceDTO $dto): array
    {
        return array_merge(
            [
                [
                    'type' => 'text',
                    'text' => $dto->query,
                ],

                [
                    'type' => 'text',
                    'text' => "OPTION 1 TEXT:\n" . $dto->option1Text,
                ],
            ],

            $this->buildCardsBlock('OPTION 1 CARDS', $dto->option1Cards),

            [
                [
                    'type' => 'text',
                    'text' => "OPTION 2 TEXT:\n" . $dto->option2Text,
                ],
            ],

            $this->buildCardsBlock('OPTION 2 CARDS', $dto->option2Cards),

            isset($data['selected_option'])
                ? [[
                'type' => 'text',
                'text' => "SELECTED OPTION: " . $dto->selectedOption,
            ]]
                : []
        );
    }

    private function buildCardsBlock(string $label, array $cards): array
    {
        $result = [];

        $result[] = [
            'type' => 'text',
            'text' => $label,
        ];

        foreach ($cards as $index => $card) {
            $result[] = [
                'type' => 'text',
                'text' => "Card " . ($index + 1),
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
