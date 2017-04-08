<?php

namespace SubtitleProviders\SubDb;

class HashGenerator
{
    /**
     * The first 64kb and last 64kb of the file should be used to create a hash
     */
    Const READSIZE = 64 * 1024;

    /**
     * @param string $filename
     * @return string
     */
    public function generateForFilePath($filename)
    {
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException('Video file does not exist'); // todo domain specific exceptions
        }
        $firstBytes = file_get_contents($filename, false, null, 0, static::READSIZE);
        if ($firstBytes === false) {
            throw new \InvalidArgumentException('Video file does not exist');
        }
        $size = filesize($filename);
        $offset = $size - static::READSIZE;
        $lastBytes = file_get_contents($filename, false, null,$offset, static::READSIZE);
        if ($lastBytes === false) {
            throw new \InvalidArgumentException('Video file does not exist');
        }
        $data = $firstBytes . $lastBytes;
        if (strlen($data) === 0) {
            throw new \RuntimeException('Unable to create video hash');
        }
        return md5($data);
    }
}
