<?php

namespace App\Command;

use App\Model\News;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[
    AsCommand(
        name: 'news:add',
        description: 'Add news to the database'
    )
]
class AddNews extends AbstractCommand
{
    /**
     * Configure the current command
     */
    protected function configure(): void
    {
        $this->addArgument('title', InputArgument::REQUIRED, 'Article Title');
        $this->addArgument('description', InputArgument::REQUIRED, 'Article Description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->greetings($output, "Saving new article");

        $news = new News();
        $news->title = $input->getArgument("title");
        $news->body = $input->getArgument("description");
        $news->created_at = date("Y:m:d H:i:s");

        $news->save();

        $output->writeln("<info>Article was save successfully.</info> Use <comment>php console news:read " .
            $news->id ."</comment> command to see the content.");

        return Command::SUCCESS;
    }
}