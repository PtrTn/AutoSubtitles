<?php

namespace Tests\SubtitleProviders\SubDb;

use SubtitleProviders\SubDb\HashGenerator;
use Helpers\FixtureAware;

class HashGeneratorTest extends \PHPUnit_Framework_TestCase
{
    use FixtureAware;

    /**
     * @var HashGenerator
     */
    private $hashGenerator;

    public function setUp()
    {
        $this->hashGenerator = new HashGenerator();
    }

    /**
     * @test
     */
    public function shouldGenerateHashForFile()
    {
        $fixturePath = $this->getFixturePathByName('dexter.mp4');
        $actualHash = $this->hashGenerator->generateForFilePath($fixturePath);
        $expectedHash = 'ffd8d4aa68033dc03d1c8ef373b9028c';
        $this->assertEquals($expectedHash, $actualHash);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Unable to create video hash
     */
    public function shouldErrorOnInvalidFile()
    {
        $invalidFixture = $this->getFixturePathByName('invalid-video.mp4');
        $this->hashGenerator->generateForFilePath($invalidFixture);
    }
}
