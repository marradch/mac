<?php

namespace App\AI\MessagesBuilder;

use App\AI\Prompt\TimeSpreadMultiCardPrompt;
use App\AI\DTO\MetaphoricalCard;
use App\DTO\Input\InterpretDTOInterface;

class TimeSpreadMessagesBuilder implements MessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => TimeSpreadMultiCardPrompt::$prompt[$locale],
            ],
            [
                'role' => 'user',
                'content' => array_merge(
                    [
                        [
                            'type' => 'text',
                            'text' => $dto->query,
                        ],
                    ],
                    $this->buildCardsContent($dto)
                ),
            ],
        ];
    }

    private function buildCardsContent(InterpretDTOInterface $dto): array
    {
        $result = [];

        $result[] = [
            'type' => 'text',
            'text' => "PAST CARDS:",
        ];

        foreach ($dto->past as $index => $card) {
            foreach ($this->cardBlock('Past', $index + 1, $card) as $block) {
                $result[] = $block;
            }
        }

        $result[] = [
            'type' => 'text',
            'text' => "PRESENT CARDS:",
        ];

        foreach ($dto->present as $index => $card) {
            foreach ($this->cardBlock('Present', $index + 1, $card) as $block) {
                $result[] = $block;
            }
        }

        $result[] = [
            'type' => 'text',
            'text' => "FUTURE CARDS:",
        ];

        foreach ($dto->future as $index => $card) {
            foreach ($this->cardBlock('Future', $index + 1, $card) as $block) {
                $result[] = $block;
            }
        }

        return $result;
    }

    private function cardBlock(string $layer, int $index, MetaphoricalCard $card): array
    {
        return [
            [
                'type' => 'text',
                'text' => "{$layer} card {$index}",
            ],
            [
                'type' => 'image_url',
                'image_url' => [
                    'url' => $card->imageUrl,
                ],
            ],
        ];
    }
}
