<?php
namespace Tests\ServiceProviders;

use Rpodwika\Silex\YamlConfigServiceProvider;
use ServiceProviders\ApplicationServiceProvider;
use ServiceProviders\OpenSubtitlesServiceProvider;
use ServiceProviders\SubDbServiceProvider;
use Services\SubtitleService;
use Silex\Application;

class ApplicationServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application\
     */
    private $app;

    /**
     * @test
     */
    public function shouldProvideApplicationServices()
    {
        $this->bootstrapApp();
        $this->assertInstanceOf(SubtitleService::class, $this->app[SubtitleService::class]);
    }

    private function bootstrapApp()
    {
        $this->app = new Application();
        $this->app->register(new YamlConfigServiceProvider(
            __DIR__ . '/../../app/config.yml'
        ));
        $this->app->register(new ApplicationServiceProvider());
        $this->app->register(new SubDbServiceProvider());
        $this->app->register(new OpenSubtitlesServiceProvider());
    }
}
