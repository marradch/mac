<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

interface InterpreterMessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array;
}
