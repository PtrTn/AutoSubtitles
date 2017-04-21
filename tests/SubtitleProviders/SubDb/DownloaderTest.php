<?php

namespace Tests\SubtitleProviders\SubDb;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SubtitleProviders\SubDb\Client as HttpClient;

class DownloaderTest extends \PHPUnit_Framework_TestCase
{
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
    public function shouldDownloadSubtitles()
    {
        $expectedMethod = 'GET';
        $expectedQuery = 'action=download&hash=fake-hash&language=en';
        $expectedUserAgent = 'SubDB/1.0 (AutoSubtitles/0.1; https://github.com/PtrTn/AutoSubtitles)';

        $historyContainer = [];
        $history = Middleware::history($historyContainer);
        $mockHandler = new MockHandler([new Response(200)]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new HttpClient(['handler' => $handler]);
        $downloader = new Client($mockClient);
        $downloader->downloadSubsForHash('fake-hash', $this->tempResource);
        $this->assertCount(1, $historyContainer);
        /** @var Request $request */
        $request = $historyContainer[0]['request'];
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedQuery, $request->getUri()->getQuery());
        $this->assertEquals($expectedUserAgent, $request->getHeaderLine('User-Agent'));
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Subtitles not found
     */
    public function shouldHandle404Error()
    {
        $mockClient = $this->createGuzzleMockForResponse(new Response(404));
        $downloader = new Client($mockClient);
        $downloader->downloadSubsForHash('fake-hash', $this->tempResource);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Error connection to SubDb
     */
    public function shouldHandle400Error()
    {
        $mockClient = $this->createGuzzleMockForResponse(new Response(400));
        $downloader = new Client($mockClient);
        $downloader->downloadSubsForHash('fake-hash', $this->tempResource);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Error connection to SubDb
     */
    public function shouldHandleConnectionErrors()
    {
        $mockClient = $this->createGuzzleMockForResponse(
            new Response(500)
        );

        $downloader = new Client($mockClient);
        $downloader->downloadSubsForHash('fake-hash', $this->tempResource);
    }

    /**
     * @param Response $response
     * @return Client
     */
    private function createGuzzleMockForResponse(Response $response)
    {
        $mockHandler = new MockHandler([$response]);
        $handler = HandlerStack::create($mockHandler);
        return new Client(['handler' => $handler]);
    }
}
