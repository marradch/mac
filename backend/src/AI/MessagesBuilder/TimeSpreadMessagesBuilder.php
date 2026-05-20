<?php

namespace App\AI\MessagesBuilder;

use App\AI\Prompt\TimeSpreadMultiCardPrompt;
use App\AI\DTO\MetaphoricalCard;

class TimeSpreadMessagesBuilder
{
    /**
     * @param string $locale
     * @param string $query
     * @param array{
     *     past: MetaphoricalCard[],
     *     present: MetaphoricalCard[],
     *     future: MetaphoricalCard[]
     * } $cards
     */
    public function buildMessages(string $locale, string $query, array $cards): array
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
                            'text' => $query,
                        ],
                    ],
                    $this->buildCardsContent($cards)
                ),
            ],
        ];
    }

    private function buildCardsContent(array $cards): array
    {
        $result = [];

        $result[] = [
            'type' => 'text',
            'text' => "PAST CARDS:",
        ];

        foreach ($cards['past'] ?? [] as $index => $card) {
            foreach ($this->cardBlock('Past', $index + 1, $card) as $block) {
                $result[] = $block;
            }
        }

        $result[] = [
            'type' => 'text',
            'text' => "PRESENT CARDS:",
        ];

        foreach ($cards['present'] ?? [] as $index => $card) {
            foreach ($this->cardBlock('Present', $index + 1, $card) as $block) {
                $result[] = $block;
            }
        }

        $result[] = [
            'type' => 'text',
            'text' => "FUTURE CARDS:",
        ];

        foreach ($cards['future'] ?? [] as $index => $card) {
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
