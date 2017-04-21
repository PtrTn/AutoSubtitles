<?php

namespace ServiceProviders;

use Controllers\ApiController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Services\SubtitleService;
use SubtitleProviders\OpenSubtitles\Provider as OpenSubtitlesProvider;
use SubtitleProviders\SubDb\Provider as SubDbProvider;

class ApplicationServiceProvider implements ServiceProviderInterface
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
        $container[SubtitleService::class] = function () use ($container) {
            return new SubtitleService(
                $container[SubDbProvider::class],
                $container[OpenSubtitlesProvider::class]
            );
        };
        $container[ApiController::class] = function () {
            return new ApiController();
        };
    }
}
