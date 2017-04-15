<?php

namespace SubtitleProviders\SubDb;

use SubtitleProviders\GenericStorage;

class Storage
{
    /**
     * @var GenericStorage
     */
    private $storage;

    public function __construct(GenericStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $videoName
     * @return resource
     */
    public function createSubsFileByVideoName($videoName)
    {
        return $this->storage->createSubsFileByVideoName($videoName, 'SubDb');
    }
}
