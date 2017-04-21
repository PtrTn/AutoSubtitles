<?php

namespace SubtitleProviders\SubDb\Dto;

class SupportedLanguages
{
    /**
     * @var string
     */
    public $supportedLanguages;

    private function __construct()
    {
    }

    /**
     * @param string $response
     * @return SupportedLanguages
     */
    public static function createFromLanguagesResponse($response)
    {
        $supportedLanguages = new self();
        $supportedLanguages->supportedLanguages = $response;
        return $supportedLanguages;
    }

    /**
     * @param string $cache
     * @return SupportedLanguages
     */
    public static function createFromCache($cache)
    {
        $supportedLanguages = new self();
        $supportedLanguages->supportedLanguages = $cache;
        return $supportedLanguages;
    }

    /**
     * @param string $language
     * @return bool
     */
    public function isSupportedLanguage($language)
    {
        $supportedLanguages = explode(',', $this->supportedLanguages);
        return in_array($language, $supportedLanguages);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return explode(',', $this->supportedLanguages);
    }
}
