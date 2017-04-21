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
     * @param $language
     * @return resource
     */
    public function createSubsFileByVideoName($videoName, $language)
    {
        return $this->storage->createSubsFileByVideoName($videoName, $language, 'SubDb');
    }

    /**
     * @param resource $resource
     */
    public function removeResource($resource)
    {
        unlink($resource);
    }
}
