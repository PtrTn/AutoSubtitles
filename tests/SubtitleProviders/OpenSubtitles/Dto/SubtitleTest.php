<?php
namespace Tests\SubtitleProviders\OpenSubtitles\Dto;

use SubtitleProviders\OpenSubtitles\Dto\QueryParameters;
use SubtitleProviders\OpenSubtitles\Dto\Subtitle;

class SubtitleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @codingStandardsIgnoreLineLength
     */
    public function shouldCreateFromResponseItem()
    {
        $responseItem = [
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
        $subtitle = Subtitle::createFromResponseItem($responseItem);
        $this->assertEquals('moviehash', $subtitle->MatchedBy);
        $this->assertEquals('moviehash', $subtitle->MatchedBy);
        $this->assertEquals('15440724', $subtitle->IDSubMovieFile);
        $this->assertEquals('6a0187ff690440ad', $subtitle->MovieHash);
        $this->assertEquals('1860879393', $subtitle->MovieByteSize);
        $this->assertEquals('0', $subtitle->MovieTimeMS);
        $this->assertEquals('1955459961', $subtitle->IDSubtitleFile);
        $this->assertEquals('Legion.S01E01.HDTV.x264-FLEET.srt', $subtitle->SubFileName);
        $this->assertEquals('1', $subtitle->SubActualCD);
        $this->assertEquals('54751', $subtitle->SubSize);
        $this->assertEquals('d1afeebdb81a24032c83154d5e6165cd', $subtitle->SubHash);
        $this->assertEquals('01:05:17', $subtitle->SubLastTS);
        $this->assertEquals('3', $subtitle->SubTSGroup);
        $this->assertEquals('6879468', $subtitle->IDSubtitle);
        $this->assertEquals('1566989', $subtitle->UserID);
        $this->assertEquals('eng', $subtitle->SubLanguageID);
        $this->assertEquals('srt', $subtitle->SubFormat);
        $this->assertEquals('1', $subtitle->SubSumCD);
        $this->assertEquals('', $subtitle->SubAuthorComment);
        $this->assertEquals('2017-02-09 08:36:44', $subtitle->SubAddDate);
        $this->assertEquals('0', $subtitle->SubBad);
        $this->assertEquals('0.0', $subtitle->SubRating);
        $this->assertEquals('12703', $subtitle->SubDownloadsCnt);
        $this->assertEquals('Legion.S01E01.HDTV.x264-FLEET', $subtitle->MovieReleaseName);
        $this->assertEquals('23.976', $subtitle->MovieFPS);
        $this->assertEquals('510497', $subtitle->IDMovie);
        $this->assertEquals('6143054', $subtitle->IDMovieImdb);
        $this->assertEquals('Legion" Chapter 1', $subtitle->MovieName);
        $this->assertEquals('', $subtitle->MovieNameEng);
        $this->assertEquals('2017', $subtitle->MovieYear);
        $this->assertEquals('9.0', $subtitle->MovieImdbRating);
        $this->assertEquals('0', $subtitle->SubFeatured);
        $this->assertEquals('GoldenBeard', $subtitle->UserNickName);
        $this->assertEquals('', $subtitle->SubTranslator);
        $this->assertEquals('en', $subtitle->ISO639);
        $this->assertEquals('English', $subtitle->LanguageName);
        $this->assertEquals('0', $subtitle->SubComments);
        $this->assertEquals('0', $subtitle->SubHearingImpaired);
        $this->assertEquals('administrator', $subtitle->UserRank);
        $this->assertEquals('1', $subtitle->SeriesSeason);
        $this->assertEquals('1', $subtitle->SeriesEpisode);
        $this->assertEquals('episode', $subtitle->MovieKind);
        $this->assertEquals('1', $subtitle->SubHD);
        $this->assertEquals('5114356', $subtitle->SeriesIMDBParent);
        $this->assertEquals('UTF-8', $subtitle->SubEncoding);
        $this->assertEquals('0', $subtitle->SubAutoTranslation);
        $this->assertEquals('0', $subtitle->SubForeignPartsOnly);
        $this->assertEquals('1', $subtitle->SubFromTrusted);
        $this->assertEquals(1, $subtitle->QueryCached);
        $this->assertEquals('cb55ca6ca7abfec2c163b8cf906b908d', $subtitle->SubTSGroupHash);
        $this->assertEquals(
            'http://dl.opensubtitles.org/en/download/src-api/vrf-19e60c5f/' .
            'sid-6QDNKOm3B3rGakSBKQlQd96GMl8/file/1955459961.gz',
            $subtitle->SubDownloadLink);
        $this->assertEquals(
            'http://dl.opensubtitles.org/en/download/src-api/vrf-f58a0bc9/' .
            'sid-6QDNKOm3B3rGakSBKQlQd96GMl8/sub/6879468',
            $subtitle->ZipDownloadLink);
        $this->assertEquals(
            'http://www.opensubtitles.org/en/subtitles/6879468/' .
            'sid-6QDNKOm3B3rGakSBKQlQd96GMl8/legion-legion-chapter-1-en',
            $subtitle->SubtitlesLink);
        $this->assertEquals('0', $subtitle->QueryNumber);
        $this->assertInstanceOf(QueryParameters::class, $subtitle->QueryParameters);
    }
}
