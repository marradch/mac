<?php

return [
    'slug' => 'anxiety',
    'show_on_homepage' => true,
    'homepage_order' => 5,
    'translations' => [
        'ru' => [
            'title' => 'Тревога',
            'seo_title' => 'Тревога: вопросы для самоподдержки',
            'seo_description' => 'Вопросы для исследования тревоги, страха и внутренних ресурсов.',
            'description' => 'Мягкие вопросы, которые помогают заметить переживания и найти опору.',
        ],
        'uk' => [
            'title' => 'Тривога',
            'seo_title' => 'Тривога: запитання для самопідтримки',
            'seo_description' => 'Запитання для дослідження тривоги, страху та внутрішніх ресурсів.',
            'description' => 'М’які запитання, що допомагають помітити переживання й знайти опору.',
        ],
        'en' => [
            'title' => 'Anxiety',
            'seo_title' => 'Anxiety: questions for self-support',
            'seo_description' => 'Questions to explore anxiety, fear, and inner resources.',
            'description' => 'Gentle questions to help notice your feelings and find support.',
        ],
    ],
    'questions' => [
        [
            'slug' => 'fears-and-anxieties',
            'translations' => [
                'ru' => 'Какие страхи/тревоги у меня есть?',
                'uk' => 'Які страхи/тривоги в мене є?',
                'en' => 'What fears or anxieties do I have?',
            ],
        ],
        [
            'slug' => 'hope',
            'translations' => [
                'ru' => 'Что дает мне надежду?',
                'uk' => 'Що дає мені надію?',
                'en' => 'What gives me hope?',
            ],
        ],
        [
            'slug' => 'resources-during-stress',
            'translations' => [
                'ru' => 'На какие свои ресурсы я могу опираться во время стресса/страха/тревоги?',
                'uk' => 'На які свої ресурси я можу спиратися під час стресу/страху/тривоги?',
                'en' => 'What resources can I rely on during stress, fear, or anxiety?',
            ],
        ],
        [
            'slug' => 'calm-my-anxiety',
            'translations' => [
                'ru' => 'Что мне поможет контролировать свою тревогу?',
                'uk' => 'Що допоможе мені контролювати свою тривогу?',
                'en' => 'What will help me manage my anxiety?',
            ],
        ],
        [
            'slug' => 'cause-of-anxiety',
            'translations' => [
                'ru' => 'В чем истинная причина стресса, тревоги?',
                'uk' => 'У чому справжня причина стресу, тривоги?',
                'en' => 'What is the true cause of my stress or anxiety?',
            ],
        ],
    ],
];
