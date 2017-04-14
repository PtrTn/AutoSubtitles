<?php

namespace SubtitleProviders\OpenSubtitles\Dto;

/**
 * Class SubtitleCollection
 * @package SubtitleProviders\OpenSubtitles\Dto
 *
 * @SuppressWarnings(PHPMD)
 */
class SubtitleCollection
{
    /**
     * @var string
     */
    public $status;

    /**
     * @var float
     */
    public $seconds;

    /**
     * @var Subtitle[]
     */
    public $subtitles = [];

    private function __construct()
    {
    }

    /**
     * @param array $response
     * @return SubtitleCollection
     */
    public static function fromResponse($response)
    {
        $subtitleCollection =  new static();
        $subtitleCollection->status = $response['status'];
        $subtitleCollection->seconds = $response['seconds'];
        $subtitles = [];
        foreach ($response['data'] as $responseItem) {
            $subtitles[] = Subtitle::createFromResponseItem($responseItem);
        }
        $subtitleCollection->subtitles = $subtitles;
        return $subtitleCollection;
    }

    /**
     * @param $videoFile
     * @return Subtitle
     * @internal param $fileName
     */
    public function getBestMatch($videoFile)
    {
        $fileName = pathinfo($videoFile, PATHINFO_FILENAME);
        $this->sortByRelevance($fileName);
        if (!isset($this->subtitles[0])) {
            throw new \RuntimeException('No best subtitle found');
        }
        return $this->subtitles[0];
    }

    /**
     * @param string $fileName
     */
    private function sortByRelevance($fileName)
    {
        usort($this->subtitles, function (Subtitle $subtitleA, Subtitle $subtitleB) use ($fileName) {
            $similarityA = similar_text($fileName, trim($subtitleA->MovieReleaseName));
            $similarityB = similar_text($fileName, trim($subtitleB->MovieReleaseName));

            if ($similarityA === $similarityB) {
                return 0;
            }
            if ($similarityA < $similarityB) {
                return 1;
            }
            return -1;
        });
    }
}
