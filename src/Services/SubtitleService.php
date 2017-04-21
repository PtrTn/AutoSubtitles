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
     * @param $language
     * @return int
     */
    public function downloadSubtitlesForVideoFile($videoFile, $language)
    {
        $successCount = 0;
        foreach ($this->subtitleProviders as $subtitleProvider) {
            try {
                $success = $subtitleProvider->downloadSubtitleForVideoFile($videoFile, $language);
                if ($success === true) {
                    $successCount++;
                }
            } catch (\Exception $e) {
                // If no subtitles could be retrieved $successCount will remain 0
            }
        }
        return $successCount;
    }

    /**
     * @param string $language
     * @return bool
     */
    public function isSupportedLanguage($language)
    {
        $supportedLanguages = $this->getSupportedLanguages();
        return in_array($language, $supportedLanguages);
    }

    /**
     * @return array
     */
    public function getSupportedLanguages()
    {
        return [
            'en',
            'es',
            'fr',
            'it',
            'nl',
            'pl',
            'pt',
            'ro',
            'sv',
            'tr'
        ];
    }
}
