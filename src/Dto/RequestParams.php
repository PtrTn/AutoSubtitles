<?php

namespace Dto;

use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

/**
 * Class RequestParams
 * @package Dto
 *
 * @SuppressWarnings(PHPMD)
 */
class RequestParams
{
    /**
     * @var string
     */
    public $subdb_hash;

    /**
     * @var string
     */
    public $opensubtitles_hash;

    /**
     * @var string
     */
    public $filesize;

    /**
     * @var string
     */
    public $language;

    private function __construct()
    {
    }

    /**
     * @param Request $request
     * @return static
     */
    public static function createFromRequest(Request $request)
    {
        Assert::stringNotEmpty(
            $request->request->get('subdb_hash'),
            'subdb_hash should be non-empty string'
        );
        Assert::stringNotEmpty(
            $request->request->get('opensubtitles_hash'),
            'opensubtitles_hash should be non-empty string'
        );
        Assert::stringNotEmpty(
            $request->request->get('filesize'),
            'filesize should be non-empty string'
        );
        Assert::stringNotEmpty(
            $request->request->get('language'),
            'language should be non-empty string'
        );
        $requestParams = new static();
        $requestParams->subdb_hash = $request->request->get('subdb_hash');
        $requestParams->opensubtitles_hash = $request->request->get('opensubtitles_hash');
        $requestParams->filesize = $request->request->get('filesize');
        $requestParams->language = $request->request->get('language');
        return $requestParams;
    }
}
