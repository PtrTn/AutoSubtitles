<?php

namespace SubtitleProviders;

interface SubtitleProvider
{
    function downloadSubsForVideoFile($videoFilename);
}