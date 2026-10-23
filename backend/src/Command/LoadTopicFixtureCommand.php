<?php

namespace App\Command;

use App\DataFixture\TopicFixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fixtures:load-topic',
    description: 'Loads or updates one topic fixture by slug.',
)]
class LoadTopicFixtureCommand extends Command
{
    public function __construct(
        private readonly TopicFixture $topicFixture,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('slug', InputArgument::REQUIRED, 'Topic slug to load.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $slug = (string) $input->getArgument('slug');
        $io = new SymfonyStyle($input, $output);

        if (!$this->topicFixture->loadTopic($this->entityManager, $slug)) {
            $io->error(sprintf('Topic fixture with slug "%s" was not found.', $slug));

            return Command::INVALID;
        }

        $io->success(sprintf('Topic "%s" has been loaded.', $slug));

        return Command::SUCCESS;
    }
}
