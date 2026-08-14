<?php

namespace App\DataFixture;

use App\Entity\{Deck, DeckTranslation};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class DeckFixture extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['deck'];
    }

    public function load(ObjectManager $manager): void
    {
        $items = [
            [
                'slug' => 'nature-reflections',
                'cardsCount' => 79,
                'orderInList' => 1,
                'show' => true,
                'translations' => [
                    'ru' => [
                        'title' => 'Отражения природы',
                        'description' => 'Колода, основанная на образах природы, помогает увидеть отражение внутреннего состояния через природные метафоры.'
                    ],
                    'en' => [
                        'title' => 'Nature Reflections',
                        'description' => 'A deck based on nature imagery that reflects your inner state through natural metaphors.'
                    ],
                    'ua' => [
                        'title' => 'Відображення природи',
                        'description' => 'Колода, що базується на образах природи та допомагає побачити внутрішній стан через природні метафори.'
                    ],
                ],
            ],
            [
                'slug' => 'blossom-of-wisdom',
                'cardsCount' => 2,
                'orderInList' => 2,
                'show' => true,
                'translations' => [
                    'ru' => [
                        'title' => 'Цветок мудрости',
                        'description' => 'Колода, раскрывающая внутреннюю мудрость через образы роста, расцвета и осознания.'
                    ],
                    'en' => [
                        'title' => 'Blossom of Wisdom',
                        'description' => 'A deck that раскрывает inner wisdom through symbols of growth, blooming, and awareness.'
                    ],
                    'ua' => [
                        'title' => 'Квітка мудрості',
                        'description' => 'Колода, що розкриває внутрішню мудрість через образи зростання, розквіту та усвідомлення.'
                    ],
                ],
            ],
            [
                'slug' => 'sakura',
                'cardsCount' => 2,
                'orderInList' => 3,
                'show' => true,
                'translations' => [
                    'ru' => [
                        'title' => 'Сакура',
                        'description' => 'Колода, вдохновлённая сакурой — символом мимолётности, красоты и новых начинаний.'
                    ],
                    'en' => [
                        'title' => 'Sakura',
                        'description' => 'A deck inspired by sakura — a symbol of transience, beauty, and new beginnings.'
                    ],
                    'ua' => [
                        'title' => 'Сакура',
                        'description' => 'Колода, натхненна сакурою — символом швидкоплинності, краси та нових початків.'
                    ],
                ],
            ],
        ];

        foreach ($items as $item) {
            $deck = new Deck();
            $deck->setSlug($item['slug']);
            $deck->setCardsCount($item['cardsCount']);
            $deck->setOrderInList($item['orderInList']);
            $deck->setShow($item['show']);

            $manager->persist($deck);

            foreach ($item['translations'] as $locale => $t) {
                $translation = new DeckTranslation();
                $translation->setLocale($locale);
                $translation->setTitle($t['title']);
                $translation->setDescription($t['description']);
                $translation->setDeck($deck);

                $manager->persist($translation);
            }
        }

        $manager->flush();
    }
}
