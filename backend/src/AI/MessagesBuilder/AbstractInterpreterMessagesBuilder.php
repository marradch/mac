<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

abstract class AbstractInterpreterMessagesBuilder
{
    abstract public function build(string $locale, InterpretDTOInterface $dto): array;

    protected function loadPrompt(): string
    {
        $common = file_get_contents(__DIR__ . '/../Prompt/common.md');
        $main = file_get_contents(__DIR__ . '/../Prompt/' . $this->promptFilename);

        return $common . "\n\n" . $main;
    }
}
