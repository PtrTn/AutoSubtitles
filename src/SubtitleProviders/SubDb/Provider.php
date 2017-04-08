<?php
namespace SubtitleProviders\SubDb;

use SubtitleProviders\SubtitleProvider;

class Provider implements SubtitleProvider
{
    /**
     * @var HashGenerator
     */
    private $hashGenerator;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var Downloader
     */
    private $downloader;

    /**
     * Provider constructor.
     * @param HashGenerator $hashGenerator
     * @param Storage $storage
     * @param Downloader $downloader
     */
    public function __construct(HashGenerator $hashGenerator, Storage $storage, Downloader $downloader)
    {
        $this->hashGenerator = $hashGenerator;
        $this->storage = $storage;
        $this->downloader = $downloader;
    }

    /**
     * @param string $videoFilename
     * @return bool
     */
    function downloadSubsForVideoFile($videoFilename)
    {
        $hash = $this->hashGenerator->generateForFilePath($videoFilename);
        $resource = $this->storage->createSubsFileByVideoName($videoFilename);
        $success = $this->downloader->downloadSubsForHash($hash, $resource);
        return $success;
    }
}