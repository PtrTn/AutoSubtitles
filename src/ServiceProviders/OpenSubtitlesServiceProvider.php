<?php

namespace ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use SubtitleProviders\GenericStorage;
use SubtitleProviders\OpenSubtitles\Client;
use SubtitleProviders\OpenSubtitles\Downloader;
use SubtitleProviders\OpenSubtitles\HashGenerator;
use SubtitleProviders\OpenSubtitles\Provider;
use SubtitleProviders\OpenSubtitles\Storage;
use GuzzleHttp\Client as HttpClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use fXmlRpc\Client as RpcClient;
use fXmlRpc\Transport\HttpAdapterTransport;
use Http\Discovery\MessageFactoryDiscovery;

class OpenSubtitlesServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container)
    {
        $container[Client::class] = function () {
            $httpClient = new HttpClient([
                'timeout' => 2
            ]);
            $rpcClient = new RpcClient(
                'http://api.opensubtitles.org/xml-rpc',
                new HttpAdapterTransport(
                    MessageFactoryDiscovery::find(),
                    new GuzzleAdapter($httpClient)
                )
            );
            return new Client($rpcClient);
        };
        $container[HashGenerator::class] = function () {
            return new HashGenerator();
        };
        $container[Storage::class] = function () {
            return new Storage(new GenericStorage());
        };
        $container[Downloader::class] = function () {
            $httpClient = new HttpClient([
                'timeout' => 2
            ]);
            return new Downloader($httpClient);
        };
        $container[Provider::class] = function () use ($container) {
            return new Provider(
                $container[Client::class],
                $container[HashGenerator::class],
                $container[Storage::class],
                $container[Downloader::class],
                $container['config']['providers']['opensubtitles']['username'],
                $container['config']['providers']['opensubtitles']['password'],
                $container['config']['providers']['opensubtitles']['useragent']
            );
        };
    }
}
