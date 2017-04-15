<?php

namespace SubtitleProviders;

abstract class AbstractStorage
{
    /**
     * @param string $storageFolder
     * @param string $subtitleBaseName
     * @return resource
     */
    abstract protected function createSubtitleResource($storageFolder, $subtitleBaseName);

    /**
     * @param string $videoName
     * @return resource
     */
    public function createSubsFileByVideoName($videoName)
    {
        $subtitleBaseName = $this->getBaseName($videoName);
        $storageFolder = $this->getFolder($videoName);
        return $this->createSubtitleResource($storageFolder, $subtitleBaseName);
    }

    /**
     * @param string $storageFolder
     * @param string $subtitleBaseName
     * @return resource
     */
    protected function createSubtitleResourceForIdentifier($storageFolder, $subtitleBaseName, $identifier)
    {
        $subsFile = $storageFolder . '/' . $subtitleBaseName . '.' . $identifier . '.srt';
        $resource = @fopen($subsFile, 'w+');
        if ($resource === false) {
            throw new \RuntimeException(sprintf('Unable to write subtitle file %s', $subsFile));
        }
        return $resource;
    }

    /**
     * @param $videoFile
     * @return string
     */
    private function getBaseName($videoFile)
    {
        return pathinfo($videoFile, PATHINFO_FILENAME);
    }

    /**
     * @param $videoFile
     * @return string
     */
    private function getFolder($videoFile)
    {
        return pathinfo($videoFile, PATHINFO_DIRNAME);
    }
}
