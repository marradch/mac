<?php

namespace App\Tests\Integration\AI;

use App\AI\Service\OpenAIClient;
use App\AI\MessagesBuilder\QuestionToCardMessagesBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\DTO\Input\QuestionDTO;
use App\Enum\Locale;
use App\AI\DTO\MetaphoricalCard;

class QueryValidationMassTest extends KernelTestCase
{
    private OpenAIClient $openAIClient;
    private QuestionToCardMessagesBuilder $messagesBuilder;
    private string $fileName = 'query_validation_cases_small.json';
    private string $model = 'gpt-5.6-luna';// gpt-4o-mini

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->openAIClient = $container->get(OpenAIClient::class);
        $this->openAIClient->setModel($this->model);
        $this->messagesBuilder = $container->get(
            QuestionToCardMessagesBuilder::class
        );
    }

    public function testQueryValidationMass(): void
    {
        $cases = json_decode(
            file_get_contents(
                dirname(__DIR__, 2)
                . '/Fixtures/' . $this->fileName
            ),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $errors = [];

        $stats = [
            'valid' => [
                'expected' => 0,
                'actual' => 0,
            ],
            'invalid' => [
                'expected' => 0,
                'actual' => 0,
            ],
            'medical' => [
                'expected' => 0,
                'actual' => 0,
            ],
            'unsafe' => [
                'expected' => 0,
                'actual' => 0,
            ],
        ];

        foreach ($cases as $index => $case) {
            $query = $case['query'];
            $expected = $case['expected'];
            
            fwrite(
                STDERR,
                sprintf(
                    "[%d/%d] Processing [%s] %s\n",
                    $index + 1,
                    count($cases),
                    strtoupper($expected),
                    $query
                )
            );

            $stats[$expected]['expected']++;

            try {
                $actual = $this->validateQuery($query);

                if (isset($stats[$actual])) {
                    $stats[$actual]['actual']++;
                }

                if ($actual !== $expected) {
                    $errors[] = [
                        'query' => $query,
                        'expected' => $expected,
                        'actual' => $actual,
                    ];
                }
            } catch (\Throwable $e) {
                $errors[] = [
                    'query' => $query,
                    'expected' => $expected,
                    'actual' => 'EXCEPTION',
                    'error' => $e->getMessage(),
                ];
            }
        }

        $this->printReport(
            $cases,
            $stats,
            $errors
        );

        $this->assertEmpty(
            $errors,
            sprintf(
                '%d/%d queries were classified incorrectly.',
                count($errors),
                count($cases)
            )
        );
    }

    private function validateQuery(string $query): string
    {
        $dto = new QuestionDTO(
            query: $query,
            cards: [
                new MetaphoricalCard("https://raw.githubusercontent.com/marradch/mac/master/frontend-nuxt/public/decks/nature-reflections/11.png")
        ],
        );
        $messages = $this->messagesBuilder->build(Locale::RU->value, $dto);

        $response = $this->openAIClient->ask($messages);

        return $response['query_status'];
    }

    private function printReport(
        array $cases,
        array $stats,
        array $errors
    ): void {
        fwrite(STDOUT, PHP_EOL);
        fwrite(STDOUT, "========================================\n");
        fwrite(STDOUT, "QUERY VALIDATION MASS TEST\n");
        fwrite(STDOUT, "========================================\n");

        fwrite(
            STDOUT,
            sprintf("Total:  %d\n", count($cases))
        );

        fwrite(
            STDOUT,
            sprintf("Passed: %d\n", count($cases) - count($errors))
        );

        fwrite(
            STDOUT,
            sprintf("Failed: %d\n", count($errors))
        );

        fwrite(STDOUT, PHP_EOL);

        foreach ($stats as $status => $data) {
            fwrite(
                STDOUT,
                sprintf(
                    "%-10s expected: %3d | actual: %3d\n",
                    strtoupper($status),
                    $data['expected'],
                    $data['actual']
                )
            );
        }

        if (!$errors) {
            return;
        }

        fwrite(STDOUT, PHP_EOL);
        fwrite(STDOUT, "----------------------------------------\n");
        fwrite(STDOUT, "MISCLASSIFIED\n");
        fwrite(STDOUT, "----------------------------------------\n");

        foreach ($errors as $error) {
            fwrite(
                STDOUT,
                sprintf(
                    "[%s → %s] %s\n",
                    $error['expected'],
                    $error['actual'],
                    $error['query']
                )
            );

            if (isset($error['error'])) {
                fwrite(
                    STDOUT,
                    "  ERROR: {$error['error']}\n"
                );
            }
        }
    }
}