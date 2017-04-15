<?php

namespace Services;

use SubtitleProviders\OpenSubtitles\Provider as OpenSubtitlesProvider;
use SubtitleProviders\SubDb\Provider as SubDbProvider;
use SubtitleProviders\SubtitleProvider;

class SubtitleService
{
    /**
     * @var SubtitleProvider[]
     */
    private $subtitleProviders;

    /**
     * SubtitleService constructor.
     * @param SubDbProvider $subDbProvider
     * @param OpenSubtitlesProvider $openSubsProvider
     */
    public function __construct(SubDbProvider $subDbProvider, OpenSubtitlesProvider $openSubsProvider)
    {
        $this->subtitleProviders[] = $subDbProvider;
        $this->subtitleProviders[] = $openSubsProvider;
    }

    /**
     * @param string $videoFile
     * @return int
     */
    public function downloadSubtitlesForVideoFile($videoFile)
    {
        $successCount = 0;
        foreach ($this->subtitleProviders as $subtitleProvider) {
            try {
                $success = $subtitleProvider->downloadSubtitleForVideoFile($videoFile);
                if ($success === true) {
                    $successCount++;
                }
            } catch (\Exception $e) {
            }
        }
        return $successCount;
    }
}
