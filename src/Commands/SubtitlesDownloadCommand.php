<?php

namespace Commands;

use Knp\Command\Command;
use Services\SubtitleService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SubtitlesDownloadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("app:subtitles:download")
            ->setDescription("Download subtitles for a given movie or tv series")
            ->addArgument('video file', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $videoFile = $input->getArgument('video file');
        if (!is_file($videoFile)) {
            throw new \InvalidArgumentException(sprintf('"%s" does not exist', $videoFile));
        }
        $projectDir = $this->getProjectDirectory();
        $output->writeln('Looking for subtitles');
        $app = $this->getSilexApplication();

        /** @var SubtitleService $subtitleService */
        $subtitleService = $app[SubtitleService::class];
        $successCount = $subtitleService->downloadSubtitlesForVideoFile($projectDir . $videoFile);

        if ($successCount === 0) {
            $output->writeln(sprintf('No subtitles found for "%s"', $videoFile));
            return;
        }
        $output->writeln(sprintf('Successfully downloaded %s subtitles for "%s"', $successCount, $videoFile));
        return;
    }
}
