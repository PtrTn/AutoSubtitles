<?php
namespace Tests\SubtitleProviders\OpenSubtitles\Dto;

use SubtitleProviders\OpenSubtitles\Dto\Subtitle;
use SubtitleProviders\OpenSubtitles\Dto\SubtitleCollection;

class SubtitleCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnBestMatch()
    {
        $fileName = 'something-should-match-very-well-to-this';
        $worstMatch = $this->getResponseItem();
        $worstMatch['MovieReleaseName'] = 'this-doesnt-match-very-well';
        $bestMatch = $this->getResponseItem();
        $bestMatch['MovieReleaseName'] = 'something-matches-very-well-to-this';
        $response = [
            'status' => '200 OK',
            'data' => [
                $worstMatch,
                $bestMatch
            ],
            'seconds' => 0.009
        ];
        $subtitleCollection = SubtitleCollection::fromResponse($response);
        $this->assertEquals(
            $bestMatch['IDSubMovieFile'],
            $subtitleCollection->getBestMatch($fileName)->IDSubMovieFile
        );
    }

    /**
     * @test
     */
    public function shouldCreateFromResponse()
    {
        $response = [
            'status' => '200 OK',
            'data' => [
                $this->getResponseItem(),
                $this->getResponseItem()
            ],
            'seconds' => 0.009
        ];
        $subtitleCollection = SubtitleCollection::fromResponse($response);
        $this->assertContainsOnlyInstancesOf(Subtitle::class, $subtitleCollection->subtitles);
        $this->assertEquals('200 OK', $subtitleCollection->status);
        $this->assertEquals(0.009, $subtitleCollection->seconds);
    }
    /**
     * @test
     */
    public function shouldHandleEmptyResponse()
    {
        $response = [
            'status' => '200 OK',
            'data' => [],
            'seconds' => 0.009
        ];
        $subtitleCollection = SubtitleCollection::fromResponse($response);
        $this->assertEmpty($subtitleCollection->subtitles);
    }

    /**
     * @return array
     */
    private function getResponseItem()
    {
        return [
            'MatchedBy' => 'moviehash',
            'IDSubMovieFile' => '15440724',
            'MovieHash' => '6a0187ff690440ad',
            'MovieByteSize' => '1860879393',
            'MovieTimeMS' => '0',
            'IDSubtitleFile' => '1955459961',
            'SubFileName' => 'Legion.S01E01.HDTV.x264-FLEET.srt',
            'SubActualCD' => '1',
            'SubSize' => '54751',
            'SubHash' => 'd1afeebdb81a24032c83154d5e6165cd',
            'SubLastTS' => '01:05:17',
            'SubTSGroup' => '3',
            'IDSubtitle' => '6879468',
            'UserID' => '1566989',
            'SubLanguageID' => 'eng',
            'SubFormat' => 'srt',
            'SubSumCD' => '1',
            'SubAuthorComment' => '',
            'SubAddDate' => '2017-02-09 08:36:44',
            'SubBad' => '0',
            'SubRating' => '0.0',
            'SubDownloadsCnt' => '12703',
            'MovieReleaseName' => 'Legion.S01E01.HDTV.x264-FLEET',
            'MovieFPS' => '23.976',
            'IDMovie' => '510497',
            'IDMovieImdb' => '6143054',
            'MovieName' => 'Legion" Chapter 1',
            'MovieNameEng' => '',
            'MovieYear' => '2017',
            'MovieImdbRating' => '9.0',
            'SubFeatured' => '0',
            'UserNickName' => 'GoldenBeard',
            'SubTranslator' => '',
            'ISO639' => 'en',
            'LanguageName' => 'English',
            'SubComments' => '0',
            'SubHearingImpaired' => '0',
            'UserRank' => 'administrator',
            'SeriesSeason' => '1',
            'SeriesEpisode' => '1',
            'MovieKind' => 'episode',
            'SubHD' => '1',
            'SeriesIMDBParent' => '5114356',
            'SubEncoding' => 'UTF-8',
            'SubAutoTranslation' => '0',
            'SubForeignPartsOnly' => '0',
            'SubFromTrusted' => '1',
            'QueryCached' => 1,
            'SubTSGroupHash' => 'cb55ca6ca7abfec2c163b8cf906b908d',
            'SubDownloadLink' => 'http://dl.opensubtitles.org/en/download/src-api/vrf-19e60c5f/' .
                'sid-6QDNKOm3B3rGakSBKQlQd96GMl8/file/1955459961.gz',
            'ZipDownloadLink' => 'http://dl.opensubtitles.org/en/download/src-api/vrf-f58a0bc9/' .
                'sid-6QDNKOm3B3rGakSBKQlQd96GMl8/sub/6879468',
            'SubtitlesLink' => 'http://www.opensubtitles.org/en/subtitles/6879468/' .
                'sid-6QDNKOm3B3rGakSBKQlQd96GMl8/legion-legion-chapter-1-en',
            'QueryNumber' => '0',
            'QueryParameters' => [
                'moviehash' => '6a0187ff690440ad',
                'moviebytesize' => 1860879393,
                'sublanguageid' => 'eng'
            ]
        ];
    }
}
