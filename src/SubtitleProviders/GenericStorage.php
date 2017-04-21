<?php

namespace SubtitleProviders;

class GenericStorage
{
    /**
     * @param string $videoName
     * @param $language
     * @param string $storageIdentifier
     * @return resource
     */
    public function createSubsFileByVideoName($videoName, $language, $storageIdentifier)
    {
        $subtitleBaseName = $this->getBaseName($videoName);
        $storageFolder = $this->getFolder($videoName);
        return $this->createSubtitleResource($storageFolder, $subtitleBaseName, $language, $storageIdentifier);
    }

    /**
     * @param string $storageFolder
     * @param string $subtitleBaseName
     * @param $language
     * @param string $identifier
     * @return resource
     */
    private function createSubtitleResource($storageFolder, $subtitleBaseName, $language, $identifier)
    {
        $subsFile = $storageFolder . '/' . $subtitleBaseName . '.' . $identifier . '-' . strtoupper($language) . '.srt';
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
