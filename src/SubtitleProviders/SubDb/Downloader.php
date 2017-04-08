<?php

namespace SubtitleProviders\SubDb;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

class Downloader
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * Downloader constructor.
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $hash
     * @param Resource $resource
     * @return bool
     */
    public function downloadSubsForHash($hash, $resource)
    {
        $request = $this->buildRequest($hash);
        try {
            $response = $this->httpClient->send($request, ['sink' => $resource]);
            $success = $response->getStatusCode() === 200;
            return $success;
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                throw new \RuntimeException('Subtitles not found');
            }
        } catch (\Exception $e) {
            throw new \RuntimeException('Error connection to SubDb');
        }
        throw new \RuntimeException('Error connection to SubDb');
    }

    /**
     * @param string $hash
     * @return Request
     */
    private function buildRequest($hash)
    {
        $uri = http_build_query([
            'action' => 'download',
            'hash' => $hash,
            'language' => 'en,nl'
        ]);
        $query = new Uri('?' . $uri);
        $request = new Request('GET', $query, [
            'User-Agent' => 'SubDB/1.0 (AutoSubtitles/0.1; https://github.com/PtrTn/AutoSubtitles)'
        ]);
        return $request;
    }
}
