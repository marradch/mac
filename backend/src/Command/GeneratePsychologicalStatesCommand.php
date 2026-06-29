<?php

namespace App\Command;

use App\AI\Service\PsychologicalStateService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:psychological-states:refresh',
    description: 'Clear all psychological states and regenerate them using OpenAI.',
)]
class GeneratePsychologicalStatesCommand extends Command
{
    public function __construct(
        private PsychologicalStateService $psychologicalStateService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('Clears all psychological states and refills them from the OpenAI psychological-states-generation prompt.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Psychological states regeneration');

        $io->section('Regenerating psychological states');

        try {
            $count = $this->psychologicalStateService->regenerateFromOpenAI($io);
        } catch (\Throwable $e) {
            $io->error('Failed to regenerate psychological states: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $io->success(sprintf('Psychological states regenerated successfully. Total saved: %d.', $count));
        return Command::SUCCESS;
    }
}
