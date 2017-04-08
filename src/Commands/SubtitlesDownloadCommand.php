<?php

namespace Commands;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SubtitlesDownloadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("app:subtitles:download")
            ->setDescription("A test command!");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("It works!");
    }
}
