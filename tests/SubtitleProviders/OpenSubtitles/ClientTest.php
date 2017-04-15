<?php
namespace Tests\SubtitleProviders\OpenSubtitles;

use fXmlRpc\Client as RpcClient;
use fXmlRpc\Transport\HttpAdapterTransport;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Helpers\FixtureAware;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Discovery\MessageFactoryDiscovery;
use Mockery\Mock;
use SubtitleProviders\OpenSubtitles\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    use FixtureAware;

    /**
     * @var array
     */
    private $historyContainer = [];

    /**
     * @var RpcClient|Mock
     */
    private $httpClient;

    private function createClientFromResponse($response)
    {
        $history = Middleware::history($this->historyContainer);
        $mockHandler = new MockHandler([$response]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $this->httpClient = new HttpClient(['handler' => $handler]);
        $rpcClient = new RpcClient(
            'http://api.opensubtitles.org/xml-rpc',
            new HttpAdapterTransport(
                MessageFactoryDiscovery::find(),
                new GuzzleAdapter($this->httpClient)
            )
        );
        return new Client($rpcClient);
    }

    /**
     * @test
     */
    public function shouldLogin()
    {
        $xmlResponse = $this->getFixtureByName('fixture.xml');
        $response = new Response(200, [], $xmlResponse);
        $client = $this->createClientFromResponse($response);

        $username = 'fake-user';
        $password = 'fake-password';
        $useragent = 'fake-useragent';

        $client->login($username, $password, $useragent);
        $lastRequestXml = $this->getLastRequestXml();

        $this->assertEquals('LogIn', $lastRequestXml->methodName);
        $this->assertEquals($username, $lastRequestXml->params->param[0]->value->string);
        $this->assertEquals($password, $lastRequestXml->params->param[1]->value->string);
        $this->assertEquals('eng', $lastRequestXml->params->param[2]->value->string);
        $this->assertEquals($useragent, $lastRequestXml->params->param[3]->value->string);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Unable to login to Opensubtitles
     */
    public function shouldHandleLoginError()
    {
        $response = new Response(401);
        $client = $this->createClientFromResponse($response);

        $username = 'fake-user';
        $password = 'fake-password';
        $useragent = 'fake-useragent';

        $client->login($username, $password, $useragent);
    }

    /**
     * @test
     */
    public function shouldSearchSubtitlesByHash()
    {
        $xmlResponse = $this->getFixtureByName('fixture.xml');
        $response = new Response(200, [], $xmlResponse);
        $client = $this->createClientFromResponse($response);

        $hash = 'fake-hash';
        $filesize = 1234;

        $client->searchSubtitlesByHash($hash, $filesize);
        $lastRequestXml = $this->getLastRequestXml();

        $this->assertEquals('SearchSubtitles', $lastRequestXml->methodName);
        $requestParameters = $lastRequestXml->xpath('//struct/member');
        $this->assertEquals('eng', (string)$requestParameters[0]->value->string);
        $this->assertEquals($hash, (string)$requestParameters[1]->value->string);
        $this->assertEquals($filesize, (int)$requestParameters[2]->value->int);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Unable to search for subtitles on Opensubtitles
     */
    public function shouldHandleSearchSubtitlesByHashError()
    {
        $response = new Response(404);
        $client = $this->createClientFromResponse($response);

        $hash = 'fake-hash';
        $filesize = 1234;

        $client->searchSubtitlesByHash($hash, $filesize);
    }

    /**
     * @return \SimpleXMLElement
     */
    private function getLastRequestXml()
    {
        $this->assertArrayHasKey(0, $this->historyContainer);
        $this->assertArrayHasKey('request', $this->historyContainer[0]);

        /** @var Request $request */
        $request = $this->historyContainer[0]['request'];
        $this->assertEquals('POST', $request->getMethod());

        $requestBody = $request->getBody()->getContents();
        $xmlResponse = simplexml_load_string($requestBody);
        return $xmlResponse;
    }
}
