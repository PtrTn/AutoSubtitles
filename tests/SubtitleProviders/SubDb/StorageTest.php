<?php

namespace Tests\SubtitleProviders\SubDb;

use Helpers\FixtureAware;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use SubtitleProviders\SubDb\Storage;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    use FixtureAware;

    /**
     * @var Storage
     */
    private $storage;

    public function setUp()
    {
        $this->storage = new Storage();
    }

    /**
     * @test
     */
    public function shouldCreateSubtitleResource()
    {
        $filePath = $this->getFixturePathByName('dexter.mp4');
        $resource = $this->storage->createSubsFileByVideoName($filePath);
        $this->assertTrue(is_resource($resource), 'Subtitle file is not a resource');
        try {
            $this->getFixturePathByName('dexter.SubDb.srt');
        } catch (\Exception $e) {
            $this->fail('Subtitle file should be created, but was not');
        }
        fclose($resource);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Unable to write subtitle file
     */
    public function shouldErrorForInvalidFile()
    {
        $videoFilePath = __DIR__ . '/unwriteabledir/dexter.mp4';

        $fileSystem = vfsStream::setup(__DIR__ . '/unwriteabledir');
        $fileSystem->chmod(0);

        $videoFile = new vfsStreamFile($videoFilePath);
        $fileSystem->addChild($videoFile);

        $this->storage->createSubsFileByVideoName($videoFilePath);
    }

    public function tearDown()
    {
        try {
            $filePath = $this->getFixturePathByName('dexter.SubDb.srt');
            unlink($filePath);
        } catch (\Exception $e) {
        }
    }
}
