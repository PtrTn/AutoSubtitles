<?php

namespace SubtitleProviders;

interface SubtitleProvider
{
    public function downloadSubsForVideoFile($videoFilename);
}
