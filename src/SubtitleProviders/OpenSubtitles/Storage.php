<?php

namespace SubtitleProviders\OpenSubtitles;

use SubtitleProviders\AbstractStorage;

class Storage extends AbstractStorage
{
    /**
     * @param string $storageFolder
     * @param string $subtitleBaseName
     * @return resource
     */
    protected function createSubtitleResource($storageFolder, $subtitleBaseName)
    {
        return parent::createSubtitleResourceForIdentifier($storageFolder, $subtitleBaseName, 'OpenSubtitles');
    }
}
