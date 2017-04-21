<?php

namespace SubtitleProviders\SubDb;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use SubtitleProviders\SubDb\Dto\SupportedLanguages;

class Client
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Downloader constructor.
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $hash
     * @param string $language
     * @param Resource $resource
     * @return bool
     */
    public function downloadSubsForHash($hash, $language, $resource)
    {
        $query = http_build_query([
            'action' => 'download',
            'hash' => $hash,
            'language' => $language
        ]);
        $request = $this->buildRequestWithQuery($query);
        try {
            $response = $this->httpClient->send($request, ['sink' => $resource]);
            $success = $response->getStatusCode() === 200;
            return $success;
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                throw new \RuntimeException('Subtitles not found');
            }
            throw new \RuntimeException('Error connection to SubDb');
        } catch (\Exception $e) {
            throw new \RuntimeException('Error connection to SubDb');
        }
    }

    /**
     * @return SupportedLanguages
     */
    public function getSupportedLanguages()
    {
        $query = http_build_query([
            'action' => 'languages'
        ]);
        $request = $this->buildRequestWithQuery($query);
        try {
            $response = $this->httpClient->send($request);
            $responseBody = $response->getBody()->getContents();
            return SupportedLanguages::createFromLanguagesResponse($responseBody);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                throw new \RuntimeException('Subtitles not found');
            }
            throw new \RuntimeException('Error connection to SubDb');
        } catch (\Exception $e) {
            throw new \RuntimeException('Error connection to SubDb');
        }
    }

    /**
     * @param string $query
     * @return Request
     * @internal param string $hash
     */
    private function buildRequestWithQuery($query)
    {
        $uri = new Uri('?' . $query);
        $request = new Request('GET', $uri, [
            'User-Agent' => 'SubDB/1.0 (AutoSubtitles/0.1; https://github.com/PtrTn/AutoSubtitles)'
        ]);
        return $request;
    }
}
