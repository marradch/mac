<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;
use App\DTO\Input\PsychologicalStatesDTO;

class PsychologicalStatesMessagesBuilder
{
    public function build(int $stateCount): array
    {
        $prompt = file_get_contents(__DIR__ . '/../Prompt/psychological-states-generation.md');
        $prompt = str_replace('{{count}}', (string)$stateCount, $prompt);

        return [
            [
                'role' => 'system',
                'content' => $prompt,
            ],
        ];
    }
}
