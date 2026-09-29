<?php

namespace App\AI\MessagesBuilder;
use App\DTO\Input\IndividualSpreadDTO;

class IndividualSpreadMessagesBuilder extends AbstractMessagesBuilder
{
    protected string $promptFilename = 'individual-spread.md';

    protected bool $hasMeditation = false;

    public function build(string $locale, object $dto): array
    {
        /** @var IndividualSpreadDTO $dto */
        return [
            [
                'role' => 'system',
                'content' => $this->loadPrompt()
            ],
            [
                'role' => 'user',
                'content' => $this->buildContent($locale, $dto)
            ]
        ];
    }

    private function buildContent(string $locale, object $dto): array
    {
        $result = [];

        $result[] = [
            'type' => 'text',
            'text' => "LANGUAGE: {$locale}",
        ];

        $result[] = [
            'type' => 'text',
            'text' => "QUERY: {$dto->query}"
        ];

        return $result;
    }
}
