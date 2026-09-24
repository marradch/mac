<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

abstract class AbstractInterpreterMessagesBuilder
{
    protected bool $hasMeditation = false;

    abstract public function build(string $locale, InterpretDTOInterface $dto): array;

    protected function loadPrompt(): string
    {
        $common = file_get_contents(__DIR__ . '/../Prompt/common.md');
        $main = file_get_contents(__DIR__ . '/../Prompt/' . $this->promptFilename);

        $resultPrompt = $common . "\n\n" . $main;

        if ($this->hasMeditation) {
            $meditation = file_get_contents(__DIR__ . '/../Prompt/meditation.md');
            $resultPrompt .= "\n\n" . $meditation;
        }

        return $resultPrompt;
    }
}
