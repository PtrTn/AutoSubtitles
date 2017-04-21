<?php

namespace Tests\SubtitleProviders\SubDb;

use Mockery;
use SubtitleProviders\SubDb\Client;
use SubtitleProviders\SubDb\HashGenerator;
use SubtitleProviders\SubDb\Provider;
use SubtitleProviders\SubDb\Storage;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldProvideSubtitles()
    {
        $videoFileName = 'some-video-file.mp4';
        $tmpResource = tmpfile();
        $fakeHash = 'fake-hash';
        $language = 'en';

        $hashGenerator = Mockery::mock(HashGenerator::class)
            ->shouldReceive('generateForFilePath')
            ->with($videoFileName)
            ->andReturn($fakeHash)
            ->once()
            ->getMock();

        $storage = Mockery::mock(Storage::class)
            ->shouldReceive('createSubsFileByVideoName')
            ->withArgs([$videoFileName, $language])
            ->andReturn($tmpResource)
            ->once()
            ->getMock();

        $downloader = Mockery::mock(Client::class)
            ->shouldReceive('downloadSubsForHash')
            ->withArgs([$fakeHash, $language, $tmpResource])
            ->andReturn(true)
            ->once()
            ->getMock();

        $provider = new Provider($hashGenerator, $storage, $downloader);
        $success = $provider->downloadSubtitleForVideoFile($videoFileName, $language);
        $this->assertTrue($success);
        fclose($tmpResource);
    }
}
