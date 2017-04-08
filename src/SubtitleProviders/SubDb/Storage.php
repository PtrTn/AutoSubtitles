<?php

namespace SubtitleProviders\SubDb;

class Storage
{
    /**
     * @var string
     */
    private $storageFolder;

    /**
     * Storage constructor.
     * @param $storageFolder
     */
    public function __construct($storageFolder)
    {
        $this->storageFolder = $storageFolder;
    }

    /**
     * @param string $videoName
     * @return resource
     */
    public function createSubsFileByVideoName($videoName)
    {
        $baseName = $this->getBaseName($videoName);
        return $this->createSubtitleResource($baseName);
    }

    /**
     * @param $videoName
     * @return string
     */
    private function getBaseName($videoName)
    {
        return pathinfo($videoName, PATHINFO_FILENAME);
    }

    /**
     * @param string $baseName
     * @return resource
     */
    private function createSubtitleResource($baseName)
    {
        $this->createDirIfNotExists($this->storageFolder);
        $subsFile = $this->storageFolder . '/' . $baseName . '.srt';
        $resource = @fopen($subsFile, 'w+');
        if ($resource === false) {
            throw new \RuntimeException(sprintf('Unable to write subtitle file %s', $subsFile));
        }
        return $resource;
    }

    /**
     * @param string $storageFolder
     */
    private function createDirIfNotExists($storageFolder)
    {
        if (is_dir($storageFolder)) {
            return;
        }
        $success = @mkdir($storageFolder, 0777, true);
        if ($success === false) {
            throw new \RuntimeException('Unable to create storage directory');
        }
    }
}