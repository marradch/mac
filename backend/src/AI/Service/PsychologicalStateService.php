<?php

namespace App\AI\Service;

use App\AI\MessagesBuilder\PsychologicalStatesMessagesBuilder;
use App\Entity\PsychologicalState;
use App\Entity\PsychologicalStateTranslation;
use App\Repository\PsychologicalStateRepository;
use Doctrine\ORM\EntityManagerInterface;use Symfony\Component\Console\Style\SymfonyStyle;
class PsychologicalStateService
{
    private const int STATE_COUNT = 100;

    public function __construct(
        private OpenAIClient $openAIClient,
        private PsychologicalStatesMessagesBuilder $messagesBuilder,
        private PsychologicalStateRepository $psychologicalStateRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function regenerateFromOpenAI(SymfonyStyle $io): int
    {
        $this->clearAllStates();

        $messages = $this->messagesBuilder->build(self::STATE_COUNT);
        $response = $this->openAIClient->ask($messages);

        if (!is_array($response)) {
            throw new \RuntimeException('OpenAI response is invalid. Expected JSON array.');
        }

        $count = count($response);
        if ($count === 0) {
            throw new \RuntimeException('OpenAI returned no psychological states.');
        }

        return $this->savePsychologicalStates($response, $io);
    }

    public function clearAllStates(): void
    {
        $this->psychologicalStateRepository->clearAll();
    }

    private function savePsychologicalStates(array $items): int
    {
        $saved = 0;
        $usedSlugs = [];

        dump($items);

        foreach ($items as $slug => $item) {
            if (!is_array($item)) {
                throw new \RuntimeException(sprintf('Invalid item format %d.', $slug));
            }

            $englishTitle = $this->normalizeTitle($item['en'] ?? null);
            $russianTitle = $this->normalizeTitle($item['ru'] ?? null);
            $ukrainianTitle = $this->normalizeTitle($item['uk'] ?? null);

            if ($englishTitle === '' || $russianTitle === '' || $ukrainianTitle === '') {
                throw new \RuntimeException(sprintf('Missing data for item %d.', $slug));
            }

            if (isset($usedSlugs[$slug])) {
                continue;
            }

            $usedSlugs[$slug] = true;

            $state = new PsychologicalState();
            $state->setSlug($slug);
            $state->addTranslation($this->createTranslation('en', $englishTitle));
            $state->addTranslation($this->createTranslation('ru', $russianTitle));
            $state->addTranslation($this->createTranslation('uk', $ukrainianTitle));

            $this->entityManager->persist($state);
            $saved++;

            if ($saved % 20 === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $saved;
    }

    private function createTranslation(string $locale, string $title): PsychologicalStateTranslation
    {
        $translation = new PsychologicalStateTranslation();
        $translation->setLocale($locale);
        $translation->setTitle($title);

        return $translation;
    }

    private function normalizeSlug(?string $slug): string
    {
        if ($slug === null) {
            return '';
        }

        return mb_strtolower(trim($slug));
    }

    private function normalizeTitle(?string $title): string
    {
        return $title === null ? '' : trim($title);
    }
}
