<?php

namespace Tests\SubtitleProviders\SubDb;

use Mockery;
use SubtitleProviders\SubDb\Downloader;
use SubtitleProviders\SubDb\HashGenerator;
use SubtitleProviders\SubDb\Provider;
use SubtitleProviders\SubDb\Storage;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldProvideSubtitles()
    {
        $videoFileName = 'some-video-file.mp4';
        $tmpResource = tmpfile();
        $fakeHash = 'fake-hash';
        $hashGenerator = Mockery::mock(HashGenerator::class)
            ->shouldReceive('generateForFilePath')
            ->with($videoFileName)
            ->andReturn($fakeHash)
            ->once()
            ->getMock();
        $storage = Mockery::mock(Storage::class)
            ->shouldReceive('createSubsFileByVideoName')
            ->with($videoFileName)
            ->andReturn($tmpResource)
            ->once()
            ->getMock();
        $downloader = Mockery::mock(Downloader::class)
            ->shouldReceive('downloadSubsForHash')
            ->withArgs([$fakeHash, $tmpResource])
            ->andReturn(true)
            ->once()
            ->getMock();
        $provider = new Provider($hashGenerator, $storage, $downloader);
        $success = $provider->downloadSubtitleForVideoFile($videoFileName);
        $this->assertTrue($success);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
