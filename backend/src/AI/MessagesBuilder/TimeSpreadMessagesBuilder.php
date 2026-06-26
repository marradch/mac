<?php

namespace App\AI\MessagesBuilder;

use App\AI\DTO\MetaphoricalCard;
use App\DTO\Input\{TimeSpreadDTO, InterpretDTOInterface};

class TimeSpreadMessagesBuilder implements MessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array
    {
        return [
            [
                'role' => 'system',
                'content' => file_get_contents(__DIR__ . '/../Prompt/time-spread.md'),
            ],
            [
                'role' => 'user',
                'content' => json_encode(
                    $this->buildPayload($dto, $locale),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                ),
            ],
        ];
    }

    private function buildPayload(TimeSpreadDTO $dto, string $locale): array
    {
        $payload = [
            'language' => $locale,
            'query' => $dto->query,
            'past' => $this->mapCards($dto->past),
            'present' => $this->mapCards($dto->present),
            'future' => $this->mapCards($dto->future),
        ];

        return $payload;
    }

    private function mapCards(array $cards): array
    {
        return array_map(function ($card, $index) {
            return [
                'number' => $index + 1,
                'image_url' => $card->imageUrl,
            ];
        }, $cards, array_keys($cards));
    }
}
