<?php

namespace SubtitleProviders;

interface SubtitleProvider
{
    /**
     * @param string $videoFileName
     * @param string $language
     * @return bool
     */
    public function downloadSubtitleForVideoFile($videoFileName, $language);
}
