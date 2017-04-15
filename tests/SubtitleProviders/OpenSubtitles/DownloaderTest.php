<?php
namespace Tests\SubtitleProviders\OpenSubtitles;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use SubtitleProviders\OpenSubtitles\Downloader;

class DownloaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $historyContainer = [];
    /**
     * @var resource
     */
    private $tempResource;

    public function setUp()
    {
        $this->tempResource = tmpfile();
    }

    public function tearDown()
    {
        @fclose($this->tempResource);
    }

    /**
     * @test
     */
    public function shouldDownloadFromUrl()
    {
        $responseData = gzencode('fake-data');
        $response = new Response(200, [], $responseData);
        $downloader = $this->createDownloaderForResponse($response);
        $success = $downloader->downloadFromUrl('http://fake-url', $this->tempResource);
        $this->assertTrue($success);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Unable to download from Opensubtitles
     */
    public function shouldThrowExceptionIfDownloadingFailed()
    {
        $response = new Response(404);
        $downloader = $this->createDownloaderForResponse($response);
        $downloader->downloadFromUrl('http://fake-url', $this->tempResource);
    }

    /**
     * @param Response $response
     * @return Downloader
     */
    private function createDownloaderForResponse(Response $response)
    {
        $history = Middleware::history($this->historyContainer);
        $mockHandler = new MockHandler([$response]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new Client(['handler' => $handler]);
        return new Downloader($mockClient);
    }
}
