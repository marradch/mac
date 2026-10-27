<?php

return [
    'slug' => 'card-of-the-day',
    'show_on_homepage' => true,
    'homepage_order' => 10,
    'translations' => [
        'ru' => [
            'title' => 'Карта дня',
            'seo_title' => 'Карта дня',
            'seo_description' => 'Вопросы для осознанного начала дня.',
            'description' => 'Выберите вопрос, чтобы настроиться на день и услышать себя.',
        ],
        'uk' => [
            'title' => 'Карта дня',
            'seo_title' => 'Карта дня',
            'seo_description' => 'Запитання для усвідомленого початку дня.',
            'description' => 'Оберіть запитання, щоб налаштуватися на день і почути себе.',
        ],
        'en' => [
            'title' => 'Card of the Day',
            'seo_title' => 'Card of the Day',
            'seo_description' => 'Questions for a mindful start to your day.',
            'description' => 'Choose a question to tune into your day and listen to yourself.',
        ],
    ],
    'questions' => [
        [
            'slug' => 'do-for-myself-and-the-world',
            'translations' => [
                'ru' => 'Что я могу сегодня сделать для себя? Для мира?',
                'uk' => 'Що я можу сьогодні зробити для себе? Для світу?',
                'en' => 'What can I do for myself today? For the world?',
            ],
        ],
        [
            'slug' => 'what-only-i-can-do',
            'translations' => [
                'ru' => 'Что я могу сегодня сделать из того, что никто не сделает кроме меня?',
                'uk' => 'Що я можу сьогодні зробити з того, чого ніхто, крім мене, не зробить?',
                'en' => 'What can I do today that no one else can do but me?',
            ],
        ],
        [
            'slug' => 'how-do-i-feel-now',
            'translations' => [
                'ru' => 'Как я себя сейчас чувствую?',
                'uk' => 'Як я зараз почуваюся?',
                'en' => 'How do I feel right now?',
            ],
        ],
        [
            'slug' => 'message-for-the-day',
            'translations' => [
                'ru' => 'Карта-послание на день',
                'uk' => 'Карта-послання на день',
                'en' => 'A message card for the day',
            ],
        ],
        [
            'slug' => 'care-for-myself',
            'translations' => [
                'ru' => 'Как я могу сегодня позаботиться о себе?',
                'uk' => 'Як я можу сьогодні подбати про себе?',
                'en' => 'How can I take care of myself today?',
            ],
        ],
    ],
];
