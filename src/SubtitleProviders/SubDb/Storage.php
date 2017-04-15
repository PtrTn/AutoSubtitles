<?php

namespace SubtitleProviders\SubDb;

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
        return parent::createSubtitleResourceForIdentifier($storageFolder, $subtitleBaseName, 'SubDb');
    }
}
