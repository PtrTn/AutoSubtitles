<?php

namespace SubtitleProviders\SubDb;

class HashGenerator
{
    /**
     * The first 64kb and last 64kb of the file should be used to create a hash
     */
    const READSIZE = 64 * 1024;

    /**
     * @param string $filePath
     * @return string
     */
    public function generateForFilePath($filePath)
    {
        $firstBytes = file_get_contents($filePath, false, null, 0, static::READSIZE);
        if ($firstBytes === false) {
            throw new \InvalidArgumentException('Video file does not exist');
        }
        $size = filesize($filePath);
        $offset = $size - static::READSIZE;
        $lastBytes = file_get_contents($filePath, false, null, $offset, static::READSIZE);
        $data = $firstBytes . $lastBytes;
        if (strlen($data) === 0) {
            throw new \RuntimeException('Unable to create video hash');
        }
        return md5($data);
    }
}
