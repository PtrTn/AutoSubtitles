<?php

namespace Tests\SubtitleProviders\SubDb;

use SubtitleProviders\SubDb\HashGenerator;

class HashGeneratorTest extends \PHPUnit_Framework_TestCase
{
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
        $filePath = __DIR__ . '/../../fixtures/dexter.mp4';
        $actualHash = $this->hashGenerator->generateForFilePath($filePath);
        $expectedHash = 'ffd8d4aa68033dc03d1c8ef373b9028c';
        $this->assertEquals($expectedHash, $actualHash);
    }
}
