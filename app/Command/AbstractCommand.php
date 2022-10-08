<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command{

    /**
     * Print welcome message in the output
     *
     * @param OutputInterface $output
     * @param string $title
     */
    protected function greetings(OutputInterface $output, string $title): void
    {
        $output->writeln([
            '<info>Welcome in the ' . env("APP_NAME") . '</info>',
            '',
            '<info>' . $title . '</info>',
            ''
        ]);
    }    
}