<?php
namespace Tests\SubtitleProviders\OpenSubtitles\Dto;

use SubtitleProviders\OpenSubtitles\Dto\QueryParameters;

class QueryParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateFromResponseQueryParameters()
    {
        $responseQueryParameters = [
            'moviehash' => '6a0187ff690440ad',
            'moviebytesize' => 1860879393,
            'sublanguageid' => 'eng'
        ];
        $queryParams = QueryParameters::fromResponseQueryParameters($responseQueryParameters);
        $this->assertEquals('6a0187ff690440ad', $queryParams->moviehash);
        $this->assertEquals(1860879393, $queryParams->moviebytesize);
        $this->assertEquals('eng', $queryParams->sublanguageid);
    }
}
