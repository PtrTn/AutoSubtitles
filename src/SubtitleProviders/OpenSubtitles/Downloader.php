<?php

namespace SubtitleProviders\OpenSubtitles;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;

class Downloader
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Downloader constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->httpClient = $client;
    }

    /**
     * @param $url
     * @param $resource
     * @return bool
     * @throws \Exception
     */
    public function downloadFromUrl($url, $resource)
    {
        try {
            $request = new Request('GET', $url);
            $response = $this->httpClient->send($request);
            $responseBody = $response->getBody()->getContents();
            $unzipped = gzdecode($responseBody);
            fputs($resource, $unzipped);
            fclose($resource);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
        return false;
    }
}