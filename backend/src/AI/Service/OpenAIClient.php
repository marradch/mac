<?php

namespace App\AI\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAIClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey
    ) {}

    public function ask(array $messages): array
    {
        /*$response = $this->httpClient->request('POST',
            'https://api.openai.com/v1/chat/completions',
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages
                ]
            ]
        );



        $raw = $response->toArray()['choices'][0]['message']['content'];

        // 1. убрать markdown ```json ```
        $clean = preg_replace('/^```json|```$/m', '', $raw);
        $clean = trim($clean);

        // 2. decode JSON
        $data = json_decode($clean, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            die(json_last_error_msg());
        }*/
        sleep(8);

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
        ];

        /*$pos = [
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
