<?php

namespace ServiceProviders;

use SubtitleProviders\GenericStorage;
use SubtitleProviders\SubDb\Client;
use SubtitleProviders\SubDb\HashGenerator;
use SubtitleProviders\SubDb\LanguageVerifier;
use SubtitleProviders\SubDb\Provider;
use SubtitleProviders\SubDb\Storage;
use GuzzleHttp\Client as HttpClient;
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
        $container[Client::class] = function () {
            $httpClient = new HttpClient([
                'base_uri' => 'http://api.thesubdb.com'
            ]);
            return new Client($httpClient);
        };
        $container[Storage::class] = function () {
            return new Storage(new GenericStorage());
        };
        $container[Provider::class] = function () use ($container) {
            return new Provider(
                $container[HashGenerator::class],
                $container[Storage::class],
                $container[Client::class]
            );
        };
    }
}
