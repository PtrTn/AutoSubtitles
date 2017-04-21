<?php

namespace SubtitleProviders\OpenSubtitles;

use SubtitleProviders\OpenSubtitles\Dto\SubtitleCollection;
use SubtitleProviders\SubtitleProvider;
use Webmozart\Assert\Assert;

class Provider implements SubtitleProvider
{
    /**
     * @var Client
     */
    private $client;

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
     * @var
     */
    private $username;
    /**
     * @var
     */
    private $password;
    /**
     * @var
     */
    private $useragent;

    /**
     * Provider constructor.
     * @param Client $client
     * @param HashGenerator $hashGenerator
     * @param Storage $storage
     * @param Downloader $downloader
     * @param $username
     * @param $password
     * @param $useragent
     */
    public function __construct(
        Client $client,
        HashGenerator $hashGenerator,
        Storage $storage,
        Downloader $downloader,
        $username,
        $password,
        $useragent
    ) {
        $this->client = $client;
        $this->hashGenerator = $hashGenerator;
        $this->storage = $storage;
        $this->downloader = $downloader;

        Assert::stringNotEmpty($username, 'Opensubtitles.org username should be specified');
        Assert::stringNotEmpty($password, 'Opensubtitles.org password should be specified');
        Assert::stringNotEmpty($useragent, 'Opensubtitles.org useragent should be specified');

        $this->username = $username;
        $this->password = $password;
        $this->useragent = $useragent;
    }

    /**
     * @param string $videoFile
     * @param string $language
     * @return bool
     */
    public function downloadSubtitleForVideoFile($videoFile, $language)
    {
        $loginSuccess = $this->client->login($this->username, $this->password, $this->useragent);
        if (!$loginSuccess) {
            throw new \RuntimeException('Unable to login');
        }
        $hash = $this->hashGenerator->generateForFilePath($videoFile);
        $fileSize = filesize($videoFile);
        $response = $this->client->searchSubtitlesByHash($hash, $fileSize, $language);
        $collection = SubtitleCollection::fromResponse($response);
        $subtitle = $collection->getBestMatch($videoFile, $language);
        $url = $subtitle->SubDownloadLink;
        $resource = $this->storage->createSubsFileByVideoName($videoFile, $language);
        $success = $this->downloader->downloadFromUrl($url, $resource);
        return $success;
    }
}
