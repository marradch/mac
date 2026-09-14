<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\{TimeSpreadDTO, InterpretDTOInterface};

class TimeSpreadMessagesBuilder extends AbstractInterpreterMessagesBuilder
{
    protected string $promptFilename = 'time-spread.md';

    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        /** @var TimeSpreadDTO $dto */

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
            $this->buildPeriodContent('PAST', $dto->past),
            $this->buildPeriodContent('PRESENT', $dto->present),
            $this->buildPeriodContent('FUTURE', $dto->future)
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

    private function buildPeriodContent(string $period, array $cards): array
    {
        $content = [];

        foreach ($cards as $index => $card) {
            $number = $index + 1;

            $content[] = [
                'type' => 'text',
                'text' => "TIME LAYER: {$period}, CARD {$number}",
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