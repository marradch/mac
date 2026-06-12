<?php

namespace App\DataFixture;

use App\Entity\Spread;
use App\Entity\SpreadCard;
use App\Entity\SpreadCardTranslation;
use App\Entity\{Exercise, ExerciseTranslation};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ExerciseFixture extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['exercise'];
    }

    public function load(ObjectManager $manager): void
    {
        $items = [
            [
                'slug' => 'question-to-card',
                'show' => true,
                'orderInList' => 10,
                'translations' => [
                    'ru' => [
                        'title' => 'Вопрос к карте',
                        'seo_title' => 'Вопрос к карте — упражнение с метафорическими картами МАК для самопознания',
                        'seo_description' =>
                            'Упражнение «Вопрос к карте» помогает получить ответы через метафорические ассоциативные карты (МАК). Подходит для самопознания, коучинга и психологической практики. Задайте вопрос и выберите карту, чтобы увидеть подсказку через образ и ассоциации.',
                        'short_description' => 'Формулировка вопроса и получение ответа через карту.',
                        'description' =>
                            'Упражнение «Вопрос к карте» — это простой способ работы с метафорическими ассоциативными картами (МАК). Сначала введите свой запрос в текстовое поле, чтобы система могла сформировать для вас подсказку. После этого выберите карту, нажав на её рубашку. Изображение на карте запускает ассоциации и помогает по-новому взглянуть на ситуацию. Такой подход позволяет лучше понять свои чувства и внутренние процессы. Практика подходит для самопознания, коучинга и психологической работы.'
                    ],

                    'en' => [
                        'title' => 'Question to the Card',
                        'seo_title' => 'Question to the Card — exercise with metaphorical cards for self-discovery',
                        'seo_description' =>
                            'The “Question to the Card” exercise helps you get answers through metaphorical associative cards (MAC). It is suitable for self-discovery, coaching, and psychological practice. Ask a question and choose a card to see a hint through images and associations.',
                        'short_description' => 'Ask a question and receive an answer through a card.',
                        'description' =>
                            'The “Question to the Card” exercise is a simple way to work with metaphorical associative cards (MAC). First, enter your question into the text field so the system can generate a hint for you. Then choose a card by clicking on its back side. The image on the card triggers associations and helps you see the situation from a new perspective. This approach helps you better understand your feelings and inner processes. The practice is suitable for self-discovery, coaching, and psychological work.'
                    ],

                    'ua' => [
                        'title' => 'Запит до карти',
                        'seo_title' => 'Запит до карти — вправа з метафоричними картами МАК для самопізнання',
                        'seo_description' =>
                            'Вправа «Запит до карти» допомагає отримати відповіді через метафоричні асоціативні карти (МАК). Підходить для самопізнання, коучингу та психологічної практики. Сформулюйте запит і оберіть карту, щоб побачити підказку через образ і асоціації.',
                        'short_description' => 'Формулювання запиту та відповідь через карту.',
                        'description' =>
                            'Вправа «Запит до карти» — це простий спосіб роботи з метафоричними асоціативними картами (МАК). Спочатку введіть свій запит у текстове поле, щоб система могла сформувати для вас підказку. Після цього оберіть карту, натиснувши на її сорочку. Зображення на карті запускає асоціації та допомагає по-новому поглянути на ситуацію. Такий підхід дозволяє краще зрозуміти свої почуття та внутрішні процеси. Практика підходить для самопізнання, коучингу та психологічної роботи.'
                    ],
                ],
            ],
            [
                'slug' => 'choice',
                'show' => true,
                'orderInList' => 15,
                'translations' => [
                    'ru' => [
                        'title' => 'Выбор',
                        'seo_title' => 'Выбор — упражнение с метафорическими картами МАК для принятия решений',
                        'seo_description' =>
                            'Упражнение «Выбор» с метафорическими ассоциативными картами (МАК) помогает исследовать варианты решений, понять внутренние сомнения и увидеть скрытые мотивы. Подходит для самопознания, коучинга и психологической практики.',
                        'short_description' =>
                            'Исследование вариантов выбора через метафорические карты.',
                        'description' =>
                            'Упражнение с метафорическими картами «Выбор» помогает исследовать внутренние конфликты, сомнения и возможные пути принятия решения через образы и ассоциации. Участник формулирует вопрос или ситуацию, в которой необходимо сделать выбор, после чего вытягивает карты для разных вариантов или сценариев. Каждая карта помогает глубже понять эмоции, скрытые мотивы, страхи, ресурсы и возможные последствия конкретного решения. Практика позволяет увидеть ситуацию с новой стороны, лучше услышать свои внутренние потребности и прийти к более осознанному выбору. В расширенном режиме можно использовать несколько карт для каждого варианта, что делает анализ более глубоким и многослойным. Упражнение подходит для самопознания, коучинга и психологической работы.'
                    ],

                    'en' => [
                        'title' => 'Choice',
                        'seo_title' => 'Choice — exercise with metaphorical cards for decision making',
                        'seo_description' =>
                            'The “Choice” exercise with metaphorical associative cards (MAC) helps explore decision-making options, understand inner doubts, and reveal hidden motivations. Suitable for self-discovery, coaching, and psychological practice.',
                        'short_description' =>
                            'Exploring decision-making options through metaphorical cards.',
                        'description' =>
                            'The “Choice” exercise with metaphorical associative cards helps explore inner conflicts, doubts, and possible decision-making paths through images and associations. The participant formulates a question or situation that requires a choice and then draws cards for different options or scenarios. Each card helps reveal emotions, hidden motivations, fears, resources, and possible consequences of a particular decision. This practice allows you to see the situation from a new perspective, better understand your inner needs, and make a more conscious choice. In the advanced mode, several cards can be used for each option, allowing for a deeper and more layered analysis. The exercise is suitable for self-discovery, coaching, and psychological work.'
                    ],

                    'ua' => [
                        'title' => 'Вибір',
                        'seo_title' => 'Вибір — вправа з метафоричними картами МАК для прийняття рішень',
                        'seo_description' =>
                            'Вправа «Вибір» з метафоричними асоціативними картами (МАК) допомагає дослідити варіанти рішень, зрозуміти внутрішні сумніви та побачити приховані мотиви. Підходить для самопізнання, коучингу та психологічної практики.',
                        'short_description' =>
                            'Дослідження варіантів вибору через метафоричні карти.',
                        'description' =>
                            'Вправа з метафоричними картами «Вибір» допомагає дослідити внутрішні конфлікти, сумніви та можливі шляхи прийняття рішення через образи й асоціації. Учасник формулює запит або ситуацію, у якій потрібно зробити вибір, після чого витягує карти для різних варіантів чи сценаріїв. Кожна карта допомагає глибше зрозуміти емоції, приховані мотиви, страхи, ресурси та можливі наслідки конкретного рішення. Практика дозволяє побачити ситуацію з нового боку, краще почути власні внутрішні потреби та прийти до більш усвідомленого вибору. У розширеному режимі можна використовувати кілька карт для кожного варіанту, що робить аналіз глибшим і багаторівневим. Вправа підходить для самопізнання, коучингу та психологічної роботи.'
                    ],
                ],
            ],
            [
                'slug' => 'past-present-future',
                'show' => true,
                'orderInList' => 20,
                'translations' => [
                    'ru' => [
                        'title' => 'Прошлое • Настоящее • Будущее',
                        'seo_title' => 'Прошлое, Настоящее и Будущее — упражнение с метафорическими картами МАК для анализа жизни',
                        'seo_description' =>
                            'Упражнение «Прошлое, Настоящее и Будущее» с метафорическими картами (МАК) помогает исследовать жизненный путь, осознать опыт и увидеть возможные сценарии будущего. Подходит для самопознания, коучинга и психологической практики.',
                        'short_description' =>
                            'Анализ прошлого, настоящего и будущего через метафорические карты.',
                        'description' =>
                            'Упражнение с метафорическими картами «Прошлое, Настоящее и Будущее» помогает глубже исследовать свой жизненный путь и внутренние состояния через образы и ассоциации. Участник работает с тремя временными зонами: прошлым, настоящим и будущим, вытягивая карты для каждой из них и интерпретируя их через личный опыт. Прошлое помогает осознать ключевые события и их влияние, настоящее отражает текущие состояния и ресурсы, а будущее открывает возможные направления развития и цели. Также в упражнении доступен расширенный режим, в котором для каждого временного периода можно использовать не одну, а три карты — это позволяет получить более глубокий и многослойный анализ ситуации. Практика подходит для самопознания, коучинга и психологической работы.'
                    ],

                    'en' => [
                        'title' => 'Past • Present • Future',
                        'seo_title' => 'Past, Present and Future — exercise with metaphorical cards for life analysis',
                        'seo_description' =>
                            'The “Past, Present and Future” exercise with metaphorical associative cards (MAC) helps explore your life path, understand experiences, and see possible future scenarios. Suitable for self-discovery, coaching, and psychological practice.',
                        'short_description' =>
                            'Analysis of past, present and future using metaphorical cards.',
                        'description' =>
                            'The “Past, Present and Future” exercise with metaphorical associative cards helps you explore your life journey and inner states through images and associations. The participant works with three time zones: past, present, and future, drawing cards for each of them and interpreting them based on personal experience. The past helps to understand key events and their impact, the present reflects current states and resources, while the future opens possible directions and goals. The exercise also includes an advanced mode where you can use not one but three cards for each time period, allowing for a deeper and more layered analysis of the situation. This practice is suitable for self-discovery, coaching, and psychological work.'
                    ],

                    'ua' => [
                        'title' => 'Минуле • Теперішнє • Майбутнє',
                        'seo_title' => 'Минуле, Теперішнє та Майбутнє — вправа з метафоричними картами МАК для аналізу життя',
                        'seo_description' =>
                            'Вправа «Минуле, Теперішнє та Майбутнє» з метафоричними асоціативними картами (МАК) допомагає дослідити життєвий шлях, усвідомити досвід і побачити можливі сценарії майбутнього. Підходить для самопізнання, коучингу та психологічної практики.',
                        'short_description' =>
                            'Аналіз минулого, теперішнього та майбутнього через метафоричні карти.',
                        'description' =>
                            'Вправа з метафоричними картами «Минуле, Теперішнє та Майбутнє» допомагає глибше дослідити свій життєвий шлях і внутрішні стани через образи та асоціації. Учасник працює з трьома часовими зонами: минулим, теперішнім і майбутнім, витягуючи карти для кожної з них та інтерпретуючи їх через особистий досвід. Минуле допомагає усвідомити ключові події та їхній вплив, теперішнє відображає поточні стани та ресурси, а майбутнє відкриває можливі напрямки розвитку та цілі. Також у вправі доступний розширений режим, у якому для кожного часового періоду можна використовувати не одну, а три карти — це дозволяє отримати глибший і багаторівневий аналіз ситуації. Практика підходить для самопізнання, коучингу та психологічної роботи.'
                    ],
                ],
            ],
            [
                'slug' => 'resources',
                'show' => true,
                'orderInList' => 30,
                'translations' => [
                    'ru' => [
                        'title' => 'Подбор ресурса',
                        'seo_title' => 'Подбор ресурса — метафорические карты МАК для поиска внутренней опоры и поддержки запроса',
                        'seo_description' =>
                            'Упражнение «Подбор ресурса» с метафорическими картами (МАК) помогает выбрать внутренние ресурсы для поддержки запроса, получить инсайты и усилить осознанность. Можно выбрать несколько карт, получить интеллектуальную подсказку и аффирмацию для усиления состояния.',
                        'short_description' => 'Выбор внутренних ресурсов для поддержки запроса и состояния.',
                        'description' =>
                            'Упражнение «Подбор ресурса» с метафорическими картами помогает определить внутренние опоры, которые могут поддержать вас в текущем запросе или жизненной ситуации. Участник может выбрать одну или несколько карт ресурсов, которые откликаются наиболее сильно, и исследовать их значение через личные ассоциации и чувства.

Карты помогают увидеть, какие качества, состояния или внутренние опоры уже доступны вам сейчас и могут быть активированы для решения ситуации.

Дополнительно в упражнении можно получить интеллектуальную подсказку — интерпретацию выбранных ресурсов, а также аффирмацию, которая помогает закрепить позитивное состояние и усилить внутреннюю уверенность.

Практика подходит для самопомощи, коучинга, терапевтической работы и развития осознанности.'
                    ],

                    'en' => [
                        'title' => 'Resource Selection',
                        'seo_title' => 'Resource Selection — MAC metaphorical cards for finding inner support and strengthening your request',
                        'seo_description' =>
                            'The “Resource Selection” exercise with metaphorical associative cards (MAC) helps identify inner resources to support your current situation. You can choose multiple cards, receive an insight-based interpretation and an affirmation to strengthen your emotional state and clarity.',
                        'short_description' => 'Choosing internal resources to support your request and emotional state.',
                        'description' =>
                            'The “Resource Selection” exercise with metaphorical associative cards helps you identify internal resources that can support you in your current request or life situation. The participant can choose one or several resource cards that resonate most strongly and explore their meaning through personal associations and feelings.

The cards help reveal which qualities, states, or inner strengths are already available and can be activated to support the situation.

Additionally, the exercise can provide an intellectual insight — an interpretation of the selected resources — as well as an affirmation that helps anchor a positive state and strengthen inner confidence.

This practice is suitable for self-help, coaching, therapeutic work, and developing awareness.'
                    ],

                    'ua' => [
                        'title' => 'Підбір ресурсу',
                        'seo_title' => 'Підбір ресурсу — метафоричні карти МАК для пошуку внутрішньої опори та підтримки запиту',
                        'seo_description' =>
                            'Вправа «Підбір ресурсу» з метафоричними асоціативними картами (МАК) допомагає визначити внутрішні ресурси для підтримки поточного запиту. Можна обрати кілька карт, отримати інтелектуальну підказку та афірмацію для посилення стану.',
                        'short_description' => 'Вибір внутрішніх ресурсів для підтримки запиту та стану.',
                        'description' =>
                            'Вправа «Підбір ресурсу» з метафоричними асоціативними картами допомагає визначити внутрішні опори, які можуть підтримати вас у поточному запиті або життєвій ситуації. Учасник може обрати одну або кілька карт ресурсів, які найбільше відгукуються, та дослідити їх значення через особисті асоціації та відчуття.

Карти допомагають побачити, які якості, стани або внутрішні сили вже доступні та можуть бути активовані для вирішення ситуації.

Додатково у вправі можна отримати інтелектуальну підказку — інтерпретацію обраних ресурсів, а також афірмацію, яка допомагає закріпити позитивний стан і посилити внутрішню впевненість.

Практика підходить для самодопомоги, коучингу, терапевтичної роботи та розвитку усвідомленості.'
                    ],
                ],
            ],
            [
                'slug' => 'celtic-cross',
                'show' => true,
                'orderInList' => 40,

                'translations' => [
                    'ru' => [
                        'title' => 'Кельтский крест',
                        'seo_title' => 'Кельтский крест — глубокий расклад МАК для исследования жизненной ситуации',
                        'seo_description' => 'Расклад «Кельтский крест» с метафорическими картами помогает глубоко исследовать ситуацию, увидеть скрытые влияния, внутренние ресурсы, препятствия и возможное направление развития.',
                        'short_description' => 'Глубокий анализ ситуации через 10 позиций метафорических карт.',
                        'description' => '«Кельтский крест» — один из самых известных и глубоких раскладов для исследования жизненных ситуаций. С помощью десяти метафорических карт можно рассмотреть текущую ситуацию, скрытые причины происходящего, влияние прошлого опыта, внутреннее отношение, внешние факторы, надежды, опасения и возможное направление развития событий.

Расклад помогает увидеть ситуацию объемно, обнаружить новые инсайты и определить точки роста и внутренние ресурсы для дальнейших действий.'
                    ],

                    'en' => [
                        'title' => 'Celtic Cross',
                        'seo_title' => 'Celtic Cross — an in-depth MAC spread for exploring life situations',
                        'seo_description' => 'The Celtic Cross spread with metaphorical associative cards helps explore a situation deeply, uncover hidden influences, identify resources, challenges, and possible directions for development.',
                        'short_description' => 'A comprehensive 10-card exploration of a situation.',
                        'description' => 'The Celtic Cross is one of the most well-known and comprehensive spreads for exploring life situations. Using ten metaphorical cards, participants can examine the current situation, underlying causes, past influences, personal attitudes, environmental factors, hopes, fears, and potential future directions.

The spread helps create a broader perspective, discover new insights, and identify internal resources and opportunities for growth.'
                    ],

                    'ua' => [
                        'title' => 'Кельтський хрест',
                        'seo_title' => 'Кельтський хрест — глибокий розклад МАК для дослідження життєвої ситуації',
                        'seo_description' => 'Розклад «Кельтський хрест» з метафоричними асоціативними картами допомагає глибоко дослідити ситуацію, побачити приховані впливи, ресурси, перешкоди та можливий напрямок розвитку.',
                        'short_description' => 'Глибокий аналіз ситуації через 10 позицій метафоричних карт.',
                        'description' => '«Кельтський хрест» — один із найвідоміших і найглибших розкладів для дослідження життєвих ситуацій. За допомогою десяти метафоричних карт можна розглянути поточну ситуацію, приховані причини подій, вплив минулого досвіду, власне ставлення, зовнішні фактори, надії, побоювання та можливий напрямок розвитку.

Розклад допомагає побачити ситуацію об’ємніше, знайти нові інсайти та визначити внутрішні ресурси й точки зростання для подальших дій.'
                    ],
                ],
                'card_positions' => [
                    [
                        'slug' => 'current_situation',
                        'orderInList' => 1,
                        'translations' => [
                            'ru' => ['title' => 'Текущая ситуация'],
                            'en' => ['title' => 'Current Situation'],
                            'ua' => ['title' => 'Поточна ситуація'],
                        ],
                    ],
                    [
                        'slug' => 'challenge',
                        'orderInList' => 2,
                        'translations' => [
                            'ru' => ['title' => 'Что препятствует или влияет'],
                            'en' => ['title' => 'Challenge or Influencing Factor'],
                            'ua' => ['title' => 'Що впливає або створює перешкоди'],
                        ],
                    ],
                    [
                        'slug' => 'conscious_goal',
                        'orderInList' => 3,
                        'translations' => [
                            'ru' => ['title' => 'Осознанная цель или намерение'],
                            'en' => ['title' => 'Conscious Goal or Intention'],
                            'ua' => ['title' => 'Усвідомлена мета або намір'],
                        ],
                    ],
                    [
                        'slug' => 'root_cause',
                        'orderInList' => 4,
                        'translations' => [
                            'ru' => ['title' => 'Корни ситуации'],
                            'en' => ['title' => 'Roots of the Situation'],
                            'ua' => ['title' => 'Коріння ситуації'],
                        ],
                    ],
                    [
                        'slug' => 'past_influence',
                        'orderInList' => 5,
                        'translations' => [
                            'ru' => ['title' => 'Влияние прошлого'],
                            'en' => ['title' => 'Past Influence'],
                            'ua' => ['title' => 'Вплив минулого'],
                        ],
                    ],
                    [
                        'slug' => 'near_future',
                        'orderInList' => 6,
                        'translations' => [
                            'ru' => ['title' => 'Вероятное развитие'],
                            'en' => ['title' => 'Likely Development'],
                            'ua' => ['title' => 'Ймовірний розвиток'],
                        ],
                    ],
                    [
                        'slug' => 'self_perception',
                        'orderInList' => 7,
                        'translations' => [
                            'ru' => ['title' => 'Ваше отношение к ситуации'],
                            'en' => ['title' => 'Your Attitude Toward the Situation'],
                            'ua' => ['title' => 'Ваше ставлення до ситуації'],
                        ],
                    ],
                    [
                        'slug' => 'environment',
                        'orderInList' => 8,
                        'translations' => [
                            'ru' => ['title' => 'Влияние окружения'],
                            'en' => ['title' => 'External Influences'],
                            'ua' => ['title' => 'Вплив оточення'],
                        ],
                    ],
                    [
                        'slug' => 'hopes_and_fears',
                        'orderInList' => 9,
                        'translations' => [
                            'ru' => ['title' => 'Надежды и опасения'],
                            'en' => ['title' => 'Hopes and Fears'],
                            'ua' => ['title' => 'Надії та побоювання'],
                        ],
                    ],
                    [
                        'slug' => 'outcome',
                        'orderInList' => 10,
                        'translations' => [
                            'ru' => ['title' => 'Потенциальный результат'],
                            'en' => ['title' => 'Potential Outcome'],
                            'ua' => ['title' => 'Потенційний результат'],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'man-woman-pair',
                'show' => true,
                'orderInList' => 50,
                'translations' => [
                    'ru' => [
                        'title' => 'Подбор пары',
                        'short_description' => 'Исследование взаимодействия мужского и женского архетипа.',
                        'description' =>
                            'Вытяните одну карту мужчины и одну карту женщины. ' .
                            'Рассмотрите их как две части одной системы или взаимодействия. ' .
                            'Какие качества они отражают? Как они проявляются в отношениях, внутри вас или в ситуации? ' .
                            'Обратите внимание на их взаимодействие: поддержка, конфликт, дистанция или притяжение.'
                    ],
                    'en' => [
                        'title' => 'Pair Matching',
                        'short_description' => 'Exploring masculine and feminine interaction.',
                        'description' =>
                            'Draw one male card and one female card. Consider them as two parts of one system or interaction. ' .
                            'What qualities do they reflect? How do they manifest in relationships, within you, or in a situation? ' .
                            'Notice their interaction: support, conflict, distance, or attraction.'
                    ],
                    'ua' => [
                        'title' => 'Підбір пари',
                        'short_description' => 'Дослідження взаємодії чоловічого та жіночого архетипів.',
                        'description' =>
                            'Витягніть одну карту чоловіка і одну карту жінки. Розгляньте їх як дві частини однієї системи або взаємодії. ' .
                            'Які якості вони відображають? Як вони проявляються у стосунках, у вас або в ситуації? ' .
                            'Зверніть увагу на їхню взаємодію: підтримка, конфлікт, дистанція або притягання.'
                    ],
                ],
            ],
        ];

        foreach ($items as $item) {
            $exercise = new Exercise();
            $exercise->setSlug($item['slug']);
            $exercise->setOrderInList($item['orderInList']);
            $exercise->setShow($item['show']);

            $manager->persist($exercise);

            foreach ($item['translations'] as $locale => $t) {
                $translation = new ExerciseTranslation();
                $translation->setLocale($locale);
                $translation->setTitle($t['title']);
                $translation->setDescription($t['description']);
                $translation->setShortDescription($t['short_description']);
                $translation->setExercise($exercise);
                $translation->setSeoDescription($t['seo_description'] ?? '');
                $translation->setSeoTitle($t['seo_title'] ?? '');

                $manager->persist($translation);
            }
            if (isset($item['card_positions'])) {
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

                    foreach ($cardPosition['translations'] as $locale => $cpTranslations) {
                        $spreadCardTranslation = new SpreadCardTranslation();
                        $spreadCardTranslation->setLocale($locale);
                        $spreadCardTranslation->setTitle($cpTranslations['title']);
                        $spreadCardTranslation->setSpreadCard($spreadCard);
                        $manager->persist($spreadCardTranslation);
                    }
                }
            }
        }

        $manager->flush();
    }
}
