<?php

namespace App\DataFixture;

use App\Entity\Exercise;
use App\Entity\ExerciseTranslation;
use App\Entity\Spread;
use App\Entity\SpreadCard;
use App\Entity\SpreadCardTranslation;
use App\Repository\ExerciseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciseFixture extends Fixture implements FixtureGroupInterface
{
    private const string DATA_DIR = __DIR__ . '/data/exercises';

    public function __construct(
        private readonly ExerciseRepository $exerciseRepository,
    ) {
    }

    public static function getGroups(): array
    {
        return ['exercise'];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loadItems() as $item) {
            $this->persistExercise($manager, $item);
        }

        $manager->flush();
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function loadItems(): array
    {
        $files = glob(self::DATA_DIR . '/*.php') ?: [];
        sort($files);

        $items = array_map(
            static fn (string $file): array => require $file,
            $files
        );

        usort(
            $items,
            static fn (array $a, array $b): int =>
                $a['orderInList'] <=> $b['orderInList']
        );

        return $items;
    }

    /**
     * @param array<string, mixed> $item
     */
    private function persistExercise(
        ObjectManager $manager,
        array $item
    ): void {
        $exercise = $this->exerciseRepository->findOneBySlug(
            $item['slug']
        );

        if ($exercise === null) {
            $exercise = new Exercise();
            $exercise->setSlug($item['slug']);

            $manager->persist($exercise);
        } else {
            $this->clearExercise($manager, $exercise);
        }

        $exercise->setOrderInList($item['orderInList']);
        $exercise->setShow($item['show']);

        $this->persistExerciseTranslations(
            $manager,
            $exercise,
            $item['translations']
        );

        if (isset($item['card_positions'])) {
            $this->persistSpread(
                $manager,
                $exercise,
                $item['card_positions']
            );
        }
    }

    /**
     * Удаляет только Spread и его дочерние сущности.
     *
     * Сам Exercise и его translations не удаляются.
     */
    private function clearExercise(
        ObjectManager $manager,
        Exercise $exercise
    ): void {
        $spread = $exercise->getSpread();

        if ($spread === null) {
            return;
        }

        foreach ($spread->getSpreadCards() as $spreadCard) {
            foreach ($spreadCard->getSpreadCardTranslations() as $translation) {
                $manager->remove($translation);
            }

            $manager->remove($spreadCard);
        }

        $manager->remove($spread);

        $exercise->setSpread(null);
    }

    /**
     * Обновляет существующие translations и создаёт отсутствующие.
     *
     * @param array<string, array<string, mixed>> $translations
     */
    private function persistExerciseTranslations(
        ObjectManager $manager,
        Exercise $exercise,
        array $translations
    ): void {
        $existingTranslations = [];

        foreach ($exercise->getTranslations() as $translation) {
            $existingTranslations[$translation->getLocale()] = $translation;
        }

        foreach ($translations as $locale => $data) {
            if (isset($existingTranslations[$locale])) {
                $translation = $existingTranslations[$locale];
            } else {
                $translation = new ExerciseTranslation();
                $translation->setExercise($exercise);

                $manager->persist($translation);
            }

            $translation->setLocale($locale);
            $translation->setTitle($data['title']);
            $translation->setDescription($data['description']);
            $translation->setShortDescription($data['short_description']);
            $translation->setSeoDescription(
                $data['seo_description'] ?? ''
            );
            $translation->setSeoTitle(
                $data['seo_title'] ?? ''
            );
        }

        // Удаляем translations, которых больше нет в fixture.
        foreach ($existingTranslations as $locale => $translation) {
            if (!isset($translations[$locale])) {
                $manager->remove($translation);
            }
        }
    }

    /**
     * @param array<int, array<string, mixed>> $cardPositions
     */
    private function persistSpread(
        ObjectManager $manager,
        Exercise $exercise,
        array $cardPositions
    ): void {
        $spread = new Spread();
        $spread->setSlug($exercise->getSlug());

        $exercise->setSpread($spread);

        $manager->persist($spread);

        foreach ($cardPositions as $cardPosition) {
            $spreadCard = new SpreadCard();

            $spreadCard->setSlug($cardPosition['slug']);
            $spreadCard->setOrderInList($cardPosition['orderInList']);
            $spreadCard->setSpread($spread);

            $manager->persist($spreadCard);

            foreach ($cardPosition['translations'] as $locale => $translation) {
                $spreadCardTranslation = new SpreadCardTranslation();

                $spreadCardTranslation->setLocale($locale);
                $spreadCardTranslation->setTitle($translation['title']);
                $spreadCardTranslation->setSpreadCard($spreadCard);

                $manager->persist($spreadCardTranslation);
            }
        }
    }
}