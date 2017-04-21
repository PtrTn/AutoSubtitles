<?php

namespace SubtitleProviders\OpenSubtitles\Dto;

/**
 * Class QueryParameters
 * @package SubtitleProviders\OpenSubtitles\Dto
 *
 * @SuppressWarnings(PHPMD)
 */
class QueryParameters
{
    /**
     * @var string
     */
    public $moviehash;

    /**
     * @var int
     */
    public $moviebytesize;

    /**
     * @var string|null
     */
    public $sublanguageid;

    private function __construct()
    {
    }

    /**
     * @param $QueryParameters
     * @return QueryParameters
     */
    public static function fromResponseQueryParameters($QueryParameters)
    {
        $queryParameters = new static();
        $queryParameters->moviehash = $QueryParameters['moviehash'];
        $queryParameters->moviebytesize = $QueryParameters['moviebytesize'];
        if (isset($QueryParameters['sublanguageid'])) {
            $queryParameters->sublanguageid = $QueryParameters['sublanguageid'];
        }
        return $queryParameters;
    }
}
