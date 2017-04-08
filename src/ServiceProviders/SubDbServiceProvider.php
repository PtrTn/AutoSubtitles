<?php

namespace ServiceProviders;

use SubtitleProviders\SubDb\Downloader;
use SubtitleProviders\SubDb\HashGenerator;
use SubtitleProviders\SubDb\Provider;
use SubtitleProviders\SubDb\Storage;
use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class SubDbServiceProvider implements ServiceProviderInterface
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
        $container[HashGenerator::class] = function () {
            return new HashGenerator();
        };
        $container[Downloader::class] = function () {
            $httpClient = new Client(['base_uri' => 'http://api.thesubdb.com']);
            return new Downloader($httpClient);
        };
        $container[Storage::class] = function () {
            return new Storage(__DIR__ . '/../../var/downloads'); // todo move to config
        };
        $container[Provider::class] = function () use ($container) {
            return new Provider(
                $container[HashGenerator::class],
                $container[Storage::class],
                $container[Downloader::class]
            );
        };
    }
}
