<?php

namespace App\Command;

use App\Model\Comment;
use App\Model\News;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[
    AsCommand(
        name: 'news:add-comment',
        description: 'Add comment to the selected article'
    )
]
class AddComment extends AbstractCommand
{
    /**
     * Configure the current command
     */
    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::REQUIRED, 'Article ID');
        $this->addArgument('comment', InputArgument::REQUIRED, 'The comment text');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->greetings($output, "Saving new comment");

        $news = News::find($input->getArgument('id'));

        if(empty($news)){
            $output->writeln("<error>The article with ID " . $input->getArgument("id") . " not found.</error>");

            return Command::INVALID;
        }

        $comment = new Comment();
        $comment->news_id = $news->id;
        $comment->body = $input->getArgument("comment");
        $comment->created_at = date("Y:m:d H:i:s");

        $comment->save();

        $output->writeln("<info>Comment was added successfully.</info> Use <comment>php console news:read " .
            $news->id ."</comment> command to see the content.");

        return Command::SUCCESS;
    }
}