<?php
namespace Tests\SubtitleProviders\OpenSubtitles;

use Helpers\FixtureAware;
use Mockery;
use SubtitleProviders\OpenSubtitles\Client;
use SubtitleProviders\OpenSubtitles\Downloader;
use SubtitleProviders\OpenSubtitles\HashGenerator;
use SubtitleProviders\OpenSubtitles\Provider;
use SubtitleProviders\OpenSubtitles\Storage;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    use FixtureAware;

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldDownloadSubtitleForVideoFile()
    {
        $fakeHash = 'fake-hash';
        $fakeDownloadUrl = 'http://fake-download.url/something';
        $username = 'fake-username';
        $password = 'fake-password';
        $useragent = 'fake-useragent';
        $videoFileName = $this->getFixturePathByName('dexter.mp4');
        $tmpResource = tmpfile();

        $searchResponse = $this->getSearchSubtitlesResponseWithDownloadUrl($fakeDownloadUrl);
        $client = Mockery::mock(Client::class)
            ->shouldReceive('login')
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('searchSubtitlesByHash')
            ->andReturn($searchResponse)
            ->getMock();

        $hashGenerator = Mockery::mock(HashGenerator::class)
            ->shouldReceive('generateForFilePath')
            ->with($videoFileName)
            ->andReturn($fakeHash)
            ->once()
            ->getMock();

        $storage = Mockery::mock(Storage::class)
            ->shouldReceive('createSubsFileByVideoName')
            ->withArgs([$videoFileName, 'en'])
            ->andReturn($tmpResource)
            ->once()
            ->getMock();

        $downloader = Mockery::mock(Downloader::class)
            ->shouldReceive('downloadFromUrl')
            ->withArgs([$fakeDownloadUrl, $tmpResource])
            ->andReturn(true)
            ->once()
            ->getMock();

        $provider = new Provider(
            $client,
            $hashGenerator,
            $storage,
            $downloader,
            $username,
            $password,
            $useragent
        );
        $success = $provider->downloadSubtitleForVideoFile($videoFileName, 'en');
        $this->assertTrue($success);
        fclose($tmpResource);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Unable to login
     */
    public function shouldHandleFailedLogin()
    {

        $videoFileName = 'some-video-file.mp4';

        $client = Mockery::mock(Client::class)
            ->shouldReceive('login')
            ->andReturn(false)
            ->getMock();

        $hashGenerator = Mockery::mock(HashGenerator::class);
        $storage = Mockery::mock(Storage::class);
        $downloader = Mockery::mock(Downloader::class);
        $username = 'fake-username';
        $password = 'fake-password';
        $useragent = 'fake-useragent';

        $provider = new Provider(
            $client,
            $hashGenerator,
            $storage,
            $downloader,
            $username,
            $password,
            $useragent
        );
        $provider->downloadSubtitleForVideoFile($videoFileName, 'en');
    }

    /**
     * @param string $downloadUrl
     * @return array
     */
    private function getSearchSubtitlesResponseWithDownloadUrl($downloadUrl)
    {
        return [
            'status' => '200 OK',
            'data' => [
                [
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
                    'SubDownloadLink' => $downloadUrl,
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
                ]
            ],
            'seconds' => 0.009
        ];
    }
}
