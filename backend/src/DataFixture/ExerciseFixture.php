<?php

namespace App\DataFixture;

use App\Entity\{Spread, SpreadCard, SpreadCardTranslation};
use App\Entity\{Exercise, ExerciseTranslation};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ExerciseFixture extends Fixture implements FixtureGroupInterface
{
    private const string DATA_DIR = __DIR__ . '/data/exercises';

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
            static fn (array $a, array $b): int => $a['orderInList'] <=> $b['orderInList']
        );

        return $items;
    }

    /**
     * @param array<string, mixed> $item
     */
    private function persistExercise(ObjectManager $manager, array $item): void
    {
        $exercise = new Exercise();
        $exercise->setSlug($item['slug']);
        $exercise->setOrderInList($item['orderInList']);
        $exercise->setShow($item['show']);

        $manager->persist($exercise);

        foreach ($item['translations'] as $locale => $translation) {
            $exerciseTranslation = new ExerciseTranslation();
            $exerciseTranslation->setLocale($locale);
            $exerciseTranslation->setTitle($translation['title']);
            $exerciseTranslation->setDescription($translation['description']);
            $exerciseTranslation->setShortDescription($translation['short_description']);
            $exerciseTranslation->setExercise($exercise);
            $exerciseTranslation->setSeoDescription($translation['seo_description'] ?? '');
            $exerciseTranslation->setSeoTitle($translation['seo_title'] ?? '');

            $manager->persist($exerciseTranslation);
        }

        if (!isset($item['card_positions'])) {
            return;
        }

        $spread = new Spread();
        $spread->setSlug($item['slug']);
        $manager->persist($spread);

        $exercise->setSpread($spread);
        $manager->persist($exercise);

        foreach ($item['card_positions'] as $cardPosition) {
            $spreadCard = new SpreadCard();
            $spreadCard->setSlug($cardPosition['slug']);
            $spreadCard->setOrderInList($cardPosition['orderInList']);
            $spreadCard->setSpread($spread);
            $manager->persist($spreadCard);

            foreach ($cardPosition['translations'] as $locale => $cardPositionTranslation) {
                $spreadCardTranslation = new SpreadCardTranslation();
                $spreadCardTranslation->setLocale($locale);
                $spreadCardTranslation->setTitle($cardPositionTranslation['title']);
                $spreadCardTranslation->setSpreadCard($spreadCard);
                $manager->persist($spreadCardTranslation);
            }
        }
    }
}
