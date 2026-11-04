<?php

return [
    'slug' => 'self-esteem',
    'show_on_homepage' => true,
    'show' => true,
    'homepage_order' => 60,
    'translations' => [
        'ru' => [
            'title' => 'Самооценка',
            'seo_title' => 'Самооценка: вопросы для самоподдержки',
            'seo_description' => 'Вопросы для бережного исследования отношения к себе.',
            'description' => 'Замечайте свои сильные стороны, ценность и внутреннюю опору.',
        ],
        'uk' => [
            'title' => 'Самооцінка',
            'seo_title' => 'Самооцінка: запитання для самопідтримки',
            'seo_description' => 'Запитання для дбайливого дослідження ставлення до себе.',
            'description' => 'Помічайте свої сильні сторони, цінність і внутрішню опору.',
        ],
        'en' => [
            'title' => 'Self-Esteem',
            'seo_title' => 'Self-esteem: questions for self-support',
            'seo_description' => 'Questions for gently exploring your relationship with yourself.',
            'description' => 'Notice your strengths, worth, and inner support.',
        ],
    ],
    'questions' => [
        [
            'slug' => 'what-do-i-value-in-myself',
            'translations' => [
                'ru' => 'Что я ценю в себе уже сейчас?',
                'uk' => 'Що я ціную в собі вже зараз?',
                'en' => 'What do I already value in myself?',
            ],
        ],
        [
            'slug' => 'my-strength-in-difficult-time',
            'translations' => [
                'ru' => 'Какие качества помогали мне в сложные времена?',
                'uk' => 'Які якості допомагали мені у складні часи?',
                'en' => 'What qualities have helped me through difficult times?',
            ],
        ],
        [
            'slug' => 'kind-words-to-myself',
            'translations' => [
                'ru' => 'Какие добрые слова я могу сказать себе сегодня?',
                'uk' => 'Які добрі слова я можу сказати собі сьогодні?',
                'en' => 'What kind words can I say to myself today?',
            ],
        ],
        [
            'slug' => 'comparison-with-others',
            'translations' => [
                'ru' => 'Что происходит со мной, когда я сравниваю себя с другими?',
                'uk' => 'Що відбувається зі мною, коли я порівнюю себе з іншими?',
                'en' => 'What happens to me when I compare myself with others?',
            ],
        ],
        [
            'slug' => 'support-myself',
            'translations' => [
                'ru' => 'Как я могу поддержать себя в момент неуверенности?',
                'uk' => 'Як я можу підтримати себе в момент невпевненості?',
                'en' => 'How can I support myself in a moment of self-doubt?',
            ],
        ],
    ],
];
