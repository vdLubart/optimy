<?php

namespace App\Command;

use App\Model\News;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[
    AsCommand(
        name: 'news:show',
        description: 'Show the first page of the news'
    )
]
class ShowNews extends AbstractCommand
{
    private InputInterface $input;

    /**
     * Configure the current command
     */
    protected function configure(): void
    {
        $this
            ->addOption('page', null,InputOption::VALUE_OPTIONAL, 'Show the specific page', 1)
            ->addOption('ipp', null,InputOption::VALUE_OPTIONAL, 'Specify items per page number', env('ITEMS_PER_PAGE', 10))
            ->addOption('text', null,InputOption::VALUE_NONE, 'Show the text description')
            ->addOption('full', null,InputOption::VALUE_NONE, 'Show the text description with comments')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->greetings($output, "The list of the latest news");

        $newsPage = News::all()
            ->sortByDesc("id")
            ->forPage($this->pageNumber(), $this->itemsPerPage())
        ;

        foreach ($newsPage as $news){
            $output->writeln('<question>['. $news->id . ']</question>: <comment>' . $news->title . '</comment> (' . $news->created_at . ')');
            if($this->isDescriptionVisible() or $this->isCommentsVisible()){
                $output->writeln('      ' . $news->body);
            }
            if($this->isCommentsVisible()){
                foreach ($news->comments as $comment){
                    $output->writeln('          > [' . $comment->created_at . '] ' . $comment->body);
                }
            }

            $output->writeln('');
        }

        return Command::SUCCESS;
    }

    /**
     * Return requested page number
     *
     * @return int
     */
    private function pageNumber(): int
    {
        return (int)$this->input->getOption('page');
    }

    /**
     * Return requested amount items per page
     *
     * @return int
     */
    private function itemsPerPage(): int
    {
        return (int)$this->input->getOption('ipp');
    }

    /**
     * Show if article description was requested
     *
     * @return bool
     */
    private function isDescriptionVisible(): bool
    {
        return (bool)$this->input->getOption('text');
    }

    /**
     * Show if comments were requested
     *
     * @return bool
     */
    private function isCommentsVisible(): bool
    {
        return (bool)$this->input->getOption('full');
    }

}