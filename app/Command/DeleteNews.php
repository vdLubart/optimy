<?php

namespace App\Command;

use App\Model\News;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

#[
    AsCommand(
        name: 'news:delete',
        description: 'Delete the selected news article'
    )
]
class DeleteNews extends AbstractCommand
{
    /**
     * Configure the current command
     */
    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Article id')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $news = News::find($input->getArgument('id'));

        if(empty($news)){
            $output->writeln("<error>The article with ID " . $input->getArgument("id") . " not found.</error>");

            return Command::INVALID;
        }

        $this->greetings($output, "Deleting news article with id " . $news->id);

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Do you really want to delete article "' . $news->title . '"? [y/n, default n]', false);

        if (!$helper->ask($input, $output, $question)) {
            return Command::SUCCESS;
        }

        $news->delete();

        $output->writeln("<info>Article was removed successfully.</info>");

        return Command::SUCCESS;
    }
}