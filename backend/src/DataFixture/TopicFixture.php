<?php

namespace App\DataFixture;

use App\Entity\Topic;
use App\Entity\TopicQuestion;
use App\Entity\TopicQuestionTranslation;
use App\Entity\TopicTranslation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TopicFixture extends Fixture implements FixtureGroupInterface
{
    private const string DATA_DIR = __DIR__ . '/data/topics';

    public static function getGroups(): array
    {
        return ['topic'];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loadItems() as $item) {
            $this->persistTopic($manager, $item);
        }

        $manager->flush();
    }

    public function loadTopic(ObjectManager $manager, string $slug): bool
    {
        foreach ($this->loadItems() as $item) {
            if ($item['slug'] !== $slug) {
                continue;
            }

            $this->persistTopic($manager, $item);
            $manager->flush();

            return true;
        }

        return false;
    }

    /** @return list<array<string, mixed>> */
    private function loadItems(): array
    {
        $files = glob(self::DATA_DIR . '/*.php') ?: [];
        sort($files);

        return array_map(static fn (string $file): array => require $file, $files);
    }

    /** @param array<string, mixed> $item */
    private function persistTopic(ObjectManager $manager, array $item): void
    {
        $topic = $manager->getRepository(Topic::class)->findOneBy([
            'slug' => $item['slug'],
        ]) ?? new Topic();

        $topic->setSlug($item['slug']);
        $topic->setShowOnHomepage($item['show_on_homepage']);
        $topic->setShow($item['show'] ?? true);
        $topic->setHomepageOrder($item['homepage_order']);
        $manager->persist($topic);

        $this->syncTopicTranslations($manager, $topic, $item['translations']);
        $this->syncQuestions($manager, $topic, $item['questions']);
    }

    /** @param array<string, array<string, string>> $translations */
    private function syncTopicTranslations(ObjectManager $manager, Topic $topic, array $translations): void
    {
        $existing = [];
        foreach ($topic->getTranslations() as $translation) {
            $existing[$translation->getLocale()] = $translation;
        }

        foreach ($translations as $locale => $data) {
            $translation = $existing[$locale] ?? new TopicTranslation();
            $translation->setTopic($topic);
            $translation->setLocale($locale);
            $translation->setTitle($data['title']);
            $translation->setSeoTitle($data['seo_title']);
            $translation->setSeoDescription($data['seo_description']);
            $translation->setDescription($data['description']);
            $manager->persist($translation);
            unset($existing[$locale]);
        }

        foreach ($existing as $translation) {
            $manager->remove($translation);
        }
    }

    /** @param list<array<string, mixed>> $questions */
    private function syncQuestions(ObjectManager $manager, Topic $topic, array $questions): void
    {
        $existing = [];
        foreach ($topic->getQuestions() as $question) {
            $existing[$question->getSlug()] = $question;
        }

        foreach ($questions as $data) {
            $question = $existing[$data['slug']] ?? new TopicQuestion();
            $question->setTopic($topic);
            $question->setSlug($data['slug']);
            $manager->persist($question);
            $this->syncQuestionTranslations($manager, $question, $data['translations']);
            unset($existing[$data['slug']]);
        }

        foreach ($existing as $question) {
            $manager->remove($question);
        }
    }

    /** @param array<string, string> $translations */
    private function syncQuestionTranslations(ObjectManager $manager, TopicQuestion $question, array $translations): void
    {
        $existing = [];
        foreach ($question->getTranslations() as $translation) {
            $existing[$translation->getLocale()] = $translation;
        }

        foreach ($translations as $locale => $text) {
            $translation = $existing[$locale] ?? new TopicQuestionTranslation();
            $translation->setQuestion($question);
            $translation->setLocale($locale);
            $translation->setText($text);
            $manager->persist($translation);
            unset($existing[$locale]);
        }

        foreach ($existing as $translation) {
            $manager->remove($translation);
        }
    }
}
