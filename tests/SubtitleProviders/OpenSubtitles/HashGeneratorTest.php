<?php

namespace Tests\SubtitleProviders\OpenSubtitles;

use Helpers\FixtureAware;
use SubtitleProviders\OpenSubtitles\HashGenerator;

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
        $fixturePath = $this->getFixturePathByName('breakdance.avi');
        $actualHash = $this->hashGenerator->generateForFilePath($fixturePath);
        $this->assertEquals('8e245d9679d31e12', $actualHash);
    }
}
