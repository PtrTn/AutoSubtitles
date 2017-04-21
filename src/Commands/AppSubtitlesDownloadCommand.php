<?php

namespace Commands;

use Knp\Command\Command;
use Services\LanguageService;
use Services\SubtitleService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppSubtitlesDownloadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("app:subtitles:download")
            ->setDescription("Download subtitles for a given movie or tv series")
            ->addArgument(
                'video file',
                InputArgument::REQUIRED,
                'The movie or tv series file for which subtitles should be downloaded'
            )
            ->addArgument('language', InputArgument::OPTIONAL, 'Language for subtitles', 'en');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $output->writeln('Verifying input video file');
        $videoFile = $input->getArgument('video file');
        if (!is_file($videoFile)) {
            throw new \InvalidArgumentException(sprintf('Video file "%s" could not be found', $videoFile));
        }

        /** @var SubtitleService $subtitleService */
        $subtitleService = $app[SubtitleService::class];

        $output->writeln('Verifying input language');
        $language = $input->getArgument('language');
        $supported = $subtitleService->isSupportedLanguage($language);
        if ($supported === false) {
            $supportedLanguages = $subtitleService->getSupportedLanguages();
            throw new \InvalidArgumentException(sprintf(
                'Language "%s" not supported, please enter one of the following options: %s"',
                $language,
                implode(', ', $supportedLanguages)
            ));
        }

        $output->writeln('Looking for subtitles');

        $successCount = $subtitleService->downloadSubtitlesForVideoFile($videoFile, $language);

        if ($successCount === 0) {
            $output->writeln(sprintf('No subtitles found for "%s" in language "%s"', $videoFile, $language));
            return;
        }
        $output->writeln(sprintf('Successfully downloaded %s subtitles "%s"', $successCount, $videoFile));
        return;
    }
}
