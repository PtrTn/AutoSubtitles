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
     * @var Client
     */
    private $client;

    /**
     * Provider constructor.
     * @param HashGenerator $hashGenerator
     * @param Storage $storage
     * @param Client $client
     */
    public function __construct(HashGenerator $hashGenerator, Storage $storage, Client $client)
    {
        $this->hashGenerator = $hashGenerator;
        $this->storage = $storage;
        $this->client = $client;
    }

    /**
     * @param string $videoFileName
     * @param string $language
     * @return bool
     */
    public function downloadSubtitleForVideoFile($videoFileName, $language)
    {
        $hash = $this->hashGenerator->generateForFilePath($videoFileName);
        $resource = $this->storage->createSubsFileByVideoName($videoFileName, $language);
        $success = $this->client->downloadSubsForHash($hash, $language, $resource);
        return $success;
    }
}
