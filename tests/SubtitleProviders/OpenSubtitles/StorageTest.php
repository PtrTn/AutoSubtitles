<?php

namespace Tests\SubtitleProviders\OpenSubtitles;

use Helpers\FixtureAware;
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
            $this->getFixturePathByName('dexter.OpenSubtitles.srt');
        } catch (\Exception $e) {
            $this->fail('Subtitle file should be created, but was not');
        }
        fclose($resource);
    }

    public function tearDown()
    {
        try {
            $filePath = $this->getFixturePathByName('dexter.OpenSubtitles.srt');
            unlink($filePath);
        } catch (\Exception $e) {
        }
    }
}
