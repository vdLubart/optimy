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
        name: 'news:read',
        description: 'Show the selected news article'
    )
]
class ReadNews extends AbstractCommand
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

        $this->greetings($output, $news->title);

        $output->writeln('  ' . $news->body);

        foreach ($news->comments as $comment){
            $output->writeln('      > [' . $comment->created_at . '] ' . $comment->body);
        }

        return Command::SUCCESS;
    }
}