<?php

namespace App\AI\MessagesBuilder;

use App\AI\DTO\MetaphoricalCard;
use App\AI\Prompt\QuestionToCardPrompt;

class QuestionToCardMessagesBuilder {
    public function buildMessages(string $locale, string $query, MetaphoricalCard $card): array
    {
        return [
            [
                'role' => 'system',
                'content' => QuestionToCardPrompt::$prompt[$locale]
            ],
            [
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => $query
                    ],
                    [
                        'type' => 'image_url',
                        'image_url' => [
                            'url' => $card->imageUrl
                        ]
                    ]
                ]
            ]
        ];
    }
}
