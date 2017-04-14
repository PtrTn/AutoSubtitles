<?php

namespace SubtitleProviders\OpenSubtitles\Dto;

/**
 * Class Subtitle
 * @package SubtitleProviders\OpenSubtitles\Dto
 *
 * @SuppressWarnings(PHPMD)
 */
class Subtitle
{
    /**
     * @var string
     */
    public $MatchedBy;

    /**
     * @var string
     */
    public $IDSubMovieFile;

    /**
     * @var string
     */
    public $MovieHash;

    /**
     * @var string
     */
    public $MovieByteSize;

    /**
     * @var string
     */
    public $MovieTimeMS;

    /**
     * @var string
     */
    public $IDSubtitleFile;

    /**
     * @var string
     */
    public $SubFileName;

    /**
     * @var string
     */
    public $SubActualCD;

    /**
     * @var string
     */
    public $SubSize;

    /**
     * @var string
     */
    public $SubHash;

    /**
     * @var string
     */
    public $SubLastTS;

    /**
     * @var string
     */
    public $SubTSGroup;

    /**
     * @var string
     */
    public $IDSubtitle;

    /**
     * @var string
     */
    public $UserID;

    /**
     * @var string
     */
    public $SubLanguageID;

    /**
     * @var string
     */
    public $SubFormat;

    /**
     * @var string
     */
    public $SubSumCD;

    /**
     * @var string
     */
    public $SubAuthorComment;

    /**
     * @var string
     */
    public $SubAddDate;

    /**
     * @var string
     */
    public $SubBad;

    /**
     * @var string
     */
    public $SubRating;

    /**
     * @var string
     */
    public $SubDownloadsCnt;

    /**
     * @var string
     */
    public $MovieReleaseName;

    /**
     * @var string
     */
    public $MovieFPS;

    /**
     * @var string
     */
    public $IDMovie;

    /**
     * @var string
     */
    public $IDMovieImdb;

    /**
     * @var string
     */
    public $MovieName;

    /**
     * @var string
     */
    public $MovieNameEng;

    /**
     * @var string
     */
    public $MovieYear;

    /**
     * @var string
     */
    public $MovieImdbRating;

    /**
     * @var string
     */
    public $SubFeatured;

    /**
     * @var string
     */
    public $UserNickName;

    /**
     * @var string
     */
    public $SubTranslator;

    /**
     * @var string
     */
    public $ISO639;

    /**
     * @var string
     */
    public $LanguageName;

    /**
     * @var string
     */
    public $SubComments;

    /**
     * @var string
     */
    public $SubHearingImpaired;

    /**
     * @var string
     */
    public $UserRank;

    /**
     * @var string
     */
    public $SeriesSeason;

    /**
     * @var string
     */
    public $SeriesEpisode;

    /**
     * @var string
     */
    public $MovieKind;

    /**
     * @var string
     */
    public $SubHD;

    /**
     * @var string
     */
    public $SeriesIMDBParent;

    /**
     * @var string
     */
    public $SubEncoding;

    /**
     * @var string
     */
    public $SubAutoTranslation;

    /**
     * @var string
     */
    public $SubForeignPartsOnly;

    /**
     * @var string
     */
    public $SubFromTrusted;

    /**
     * @var int
     */
    public $QueryCached;

    /**
     * @var string
     */
    public $SubTSGroupHash;

    /**
     * @var string
     */
    public $SubDownloadLink;

    /**
     * @var string
     */
    public $ZipDownloadLink;

    /**
     * @var string
     */
    public $SubtitlesLink;

    /**
     * @var string
     */
    public $QueryNumber;

    /**
     * @var QueryParameters
     */
    public $QueryParameters;

    private function __construct()
    {
    }

    /**
     * @param $responseItem
     * @return Subtitle
     */
    public static function createFromResponseItem($responseItem)
    {
        $subtitle = new static();
        $subtitle->MatchedBy = $responseItem['MatchedBy'];
        $subtitle->IDSubMovieFile = $responseItem['IDSubMovieFile'];
        $subtitle->MovieHash = $responseItem['MovieHash'];
        $subtitle->MovieByteSize = $responseItem['MovieByteSize'];
        $subtitle->MovieTimeMS = $responseItem['MovieTimeMS'];
        $subtitle->IDSubtitleFile = $responseItem['IDSubtitleFile'];
        $subtitle->SubFileName = $responseItem['SubFileName'];
        $subtitle->SubActualCD = $responseItem['SubActualCD'];
        $subtitle->SubSize = $responseItem['SubSize'];
        $subtitle->SubHash = $responseItem['SubHash'];
        $subtitle->SubLastTS = $responseItem['SubLastTS'];
        $subtitle->SubTSGroup = $responseItem['SubTSGroup'];
        $subtitle->IDSubtitle = $responseItem['IDSubtitle'];
        $subtitle->UserID = $responseItem['UserID'];
        $subtitle->SubLanguageID = $responseItem['SubLanguageID'];
        $subtitle->SubFormat = $responseItem['SubFormat'];
        $subtitle->SubSumCD = $responseItem['SubSumCD'];
        $subtitle->SubAuthorComment = $responseItem['SubAuthorComment'];
        $subtitle->SubAddDate = $responseItem['SubAddDate'];
        $subtitle->SubBad = $responseItem['SubBad'];
        $subtitle->SubRating = $responseItem['SubRating'];
        $subtitle->SubDownloadsCnt = $responseItem['SubDownloadsCnt'];
        $subtitle->MovieReleaseName = $responseItem['MovieReleaseName'];
        $subtitle->MovieFPS = $responseItem['MovieFPS'];
        $subtitle->IDMovie = $responseItem['IDMovie'];
        $subtitle->IDMovieImdb = $responseItem['IDMovieImdb'];
        $subtitle->MovieName = $responseItem['MovieName'];
        $subtitle->MovieNameEng = $responseItem['MovieNameEng'];
        $subtitle->MovieYear = $responseItem['MovieYear'];
        $subtitle->MovieImdbRating = $responseItem['MovieImdbRating'];
        $subtitle->SubFeatured = $responseItem['SubFeatured'];
        $subtitle->UserNickName = $responseItem['UserNickName'];
        $subtitle->SubTranslator = $responseItem['SubTranslator'];
        $subtitle->ISO639 = $responseItem['ISO639'];
        $subtitle->LanguageName = $responseItem['LanguageName'];
        $subtitle->SubComments = $responseItem['SubComments'];
        $subtitle->SubHearingImpaired = $responseItem['SubHearingImpaired'];
        $subtitle->UserRank = $responseItem['UserRank'];
        $subtitle->SeriesSeason = $responseItem['SeriesSeason'];
        $subtitle->SeriesEpisode = $responseItem['SeriesEpisode'];
        $subtitle->MovieKind = $responseItem['MovieKind'];
        $subtitle->SubHD = $responseItem['SubHD'];
        $subtitle->SeriesIMDBParent = $responseItem['SeriesIMDBParent'];
        $subtitle->SubEncoding = $responseItem['SubEncoding'];
        $subtitle->SubAutoTranslation = $responseItem['SubAutoTranslation'];
        $subtitle->SubForeignPartsOnly = $responseItem['SubForeignPartsOnly'];
        $subtitle->SubFromTrusted = $responseItem['SubFromTrusted'];
        $subtitle->QueryCached = $responseItem['QueryCached'];
        $subtitle->SubTSGroupHash = $responseItem['SubTSGroupHash'];
        $subtitle->SubDownloadLink = $responseItem['SubDownloadLink'];
        $subtitle->ZipDownloadLink = $responseItem['ZipDownloadLink'];
        $subtitle->SubtitlesLink = $responseItem['SubtitlesLink'];
        $subtitle->QueryNumber = $responseItem['QueryNumber'];
        $subtitle->QueryParameters = QueryParameters::fromResponseQueryParameters($responseItem['QueryParameters']);
        return $subtitle;
    }
}
