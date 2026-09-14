<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\{ChoiceDTO, InterpretDTOInterface};

class ChoiceMessagesBuilder extends AbstractInterpreterMessagesBuilder
{
    protected string $promptFilename = 'choice.md';

    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        /** @var ChoiceDTO $dto */

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

        $content = array_merge(
            $content,
            $this->buildOptionContent(
                'OPTION 1',
                $dto->option1Text,
                $dto->option1Cards
            ),
            $this->buildOptionContent(
                'OPTION 2',
                $dto->option2Text,
                $dto->option2Cards
            )
        );

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

    private function buildOptionContent(
        string $optionName,
        string $optionText,
        array $cards
    ): array {
        $content = [
            [
                'type' => 'text',
                'text' => "{$optionName}\nTEXT: {$optionText}",
            ],
        ];

        foreach ($cards as $index => $card) {
            $number = $index + 1;

            $content[] = [
                'type' => 'text',
                'text' => "CARD {$number}",
            ];

            $content[] = [
                'type' => 'image_url',
                'image_url' => [
                    'url' => $card->imageUrl,
                ],
            ];
        }

        return $content;
    }
}
