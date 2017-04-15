<?php
namespace Tests\ServiceProviders;

use Rpodwika\Silex\YamlConfigServiceProvider;
use ServiceProviders\ApplicationServiceProvider;
use ServiceProviders\OpenSubtitlesServiceProvider;
use ServiceProviders\SubDbServiceProvider;
use Silex\Application;
use SubtitleProviders\OpenSubtitles\Client;
use SubtitleProviders\OpenSubtitles\Downloader;
use SubtitleProviders\OpenSubtitles\HashGenerator;
use SubtitleProviders\OpenSubtitles\Provider;
use SubtitleProviders\OpenSubtitles\Storage;

class OpenSubtitlesServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @test
     */
    public function shouldProvideOpenSubtitlesServices()
    {
        $this->bootstrapApp();
        $this->assertInstanceOf(Client::class, $this->app[Client::class]);
        $this->assertInstanceOf(HashGenerator::class, $this->app[HashGenerator::class]);
        $this->assertInstanceOf(Downloader::class, $this->app[Downloader::class]);
        $this->assertInstanceOf(Storage::class, $this->app[Storage::class]);
        $this->assertInstanceOf(Provider::class, $this->app[Provider::class]);
    }

    private function bootstrapApp()
    {
        $this->app = new Application();
        $this->app->register(new YamlConfigServiceProvider(
            __DIR__ . '/../../app/config.yml.dist'
        ));
        $this->app->register(new ApplicationServiceProvider());
        $this->app->register(new SubDbServiceProvider());
        $this->app->register(new OpenSubtitlesServiceProvider());
    }
}
