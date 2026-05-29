<?php

namespace App\AI\Service\Interpreter;

use App\DTO\Input\InterpretDTOInterface;

interface InterpreterInterface
{
    public function interpret(string $locale, InterpretDTOInterface $dto): array;
}
