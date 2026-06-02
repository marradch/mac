<?php

namespace App\AI\MessagesBuilder;

use App\DTO\Input\InterpretDTOInterface;

interface MessageBuilderInterface
{
    public function build(string $locale, InterpretDTOInterface $dto): array;
}
