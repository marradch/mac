<?php

namespace App\AI\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Exception\RetryableException;

class OpenAIClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey
    ) {}

    public function ask(array $messages): array
    {
        $maxRetries = 3;

        for ($i = 0; $i < $maxRetries; $i++) {
            try {
                $response = $this->httpClient->request('POST',
                    'https://api.openai.com/v1/chat/completions',
                    [
                        'timeout' => 60,

                        'headers' => [
                            'Authorization' => 'Bearer '.$this->apiKey,
                            'Content-Type' => 'application/json',
                        ],

                        'json' => [
                            'model' => 'gpt-4o-mini',
                            'messages' => $messages,
                        ],
                    ]
                );

                $raw = $response->toArray()['choices'][0]['message']['content'];

                $clean = preg_replace('/^```json|```$/m', '', $raw);
                $clean = trim($clean);

                $data = json_decode($clean, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \RuntimeException(json_last_error_msg());
                }

                return $data;

            } catch (\Throwable $e) {

                $message = $e->getMessage();

                $retryable =
                    str_contains($message, 'Connection reset') ||
                    str_contains($message, 'timeout') ||
                    str_contains($message, 'cURL error') ||
                    str_contains($message, '503') ||
                    str_contains($message, '502') ||
                    str_contains($message, '429');

                if (!$retryable) {
                    var_dump($e->getResponse()->getContent(false));
                    throw $e;
                }

                if ($i === $maxRetries - 1) {
                    throw new RetryableException(
                        message: 'OpenAI temporary failure',
                        statusCode: 503,
                        retryAfterSeconds: 2,
                        context: [
                            'model' => 'gpt-4o-mini',
                        ]
                    );
                }

                usleep(500000 * ($i + 1));
            }
        }

        throw new \RuntimeException('OpenAI request failed after retries');
    }

    public function ask1(array $messages): array
    {
        sleep(8);
        $data = [
            "is_query_valid" => true,
            "query_feedback" => "",
            "clarifying_questions" => [],
            "past_interpretation" => "Прошлое олицетворяет гармонию и умиротворение. Это время, когда вы, возможно, ощущали глубокую связь с природой и собственными эмоциями. Ваши усилия могли противостоять препятствиям, но вы находили покой и силы для дальнейшего движения. Это время могло быть связано с важными решениями в карьере, когда вы искали свое призвание.",
            "present_interpretation" => "Настоящее символизирует рост и новые возможности. Вы находитесь в периоде, когда ваше восприятие работы наполняется светом и вдохновением. Возможно, вы находитесь на пороге нового проекта или сотрудничества, которые приносят радость. Эти цветы, распускающиеся под ясным небом, указывают на то, что ваше окружение поддерживает вас.",
            "future_interpretation" => "Будущее представляет собой путь, который ведет к неизведанным территориям. Это может означать, что вам предстоит столкнуться с новыми вызовами и возможностями. Лес — место, полное жизни и загадок, предполагает, что ваша карьера может развиваться в направлении, требующем смелости и готовности к изменениям. Путь может быть долгим, но он будет вести к значительным открытиям.",
            "cross_layer_patterns" => "Создается впечатление о гармоничном цикле развития: от внутреннего покоя в прошлом через вдохновение в настоящем к непрерывному росту в будущем.",
            "overall_narrative" => "Ваша работа движется по спирали, начиная с эмоциональной устойчивости и участия в гармонии, переходя к периоду текущего вдохновения и возможностей, и, в конечном счете, открывая двери к новым и неизведанным потенциальным успехам.",
            "affirmations" => [
                "Я открыт(а) к новым возможностям и изменениям.",
                "Я принимаю всё, что жизнь предлагает, с открытым сердцем.",
                "Я силен(сильна) и способен(способна) справляться с любыми вызовами на своём пути."
            ]
        ];

        /*sleep(8);

        $data = [
            'is_query_valid' => true,
            'query_feedback' => '',
            'clarifying_questions' => [
                'Что именно вас беспокоит в текущей ситуации?',
                'Какие качества вы уже развиваете или хотели бы развивать?',
            ],
            'interpretation' => 'Изображение дома, который взмывает в воздух благодаря воздушным шарам, может символизировать стремление к свободе и надежде. Это отображает желание людей подняться над трудностями и преодолеть барьеры.',
            'reflection_through_card' => 'Ваша ситуация может требовать отваги и решимости. Движение к мирным решениям начинается с внутреннего роста и единства. Какой путь к свободе вы видите для себя и своего народа?',
            'affirmations' => [
                'Я открываю свое сердце для любви и понимания.',
                'Я верю в силу единства и сотрудничества.',
                'Каждый шаг на пути к миру начинается с меня.',
            ],
        ];*/

        /*$data = [
            'is_query_valid' => false,
            'query_feedback' => 'Ваш вопрос является техническим и не содержит эмоционального или личного контекста.',
            'clarifying_questions' => [
                'Что для вас важно в проведении водопровода?',
                'Какие эмоции вы испытываете по этому поводу?',
                'Есть ли у вас опасения или надежды, связанные с этой задачей?',
            ],
            'interpretation' => '',
            'reflection_through_card' => '',
            'affirmations' => [],
        ];*/

        return $data;
    }
}
