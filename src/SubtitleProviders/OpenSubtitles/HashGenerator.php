<?php

namespace SubtitleProviders\OpenSubtitles;

/**
 * Class HashGenerator
 * @package SubtitleProviders\OpenSubtitles
 *
 * todo: refactor copy-pasta algorithm
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class HashGenerator
{
    /**
     * @param string $filePath
     * @return string
     */
    public function generateForFilePath($filePath)
    {
        $handle   = fopen($filePath, "rb");
        $fileSize = filesize($filePath);
        $hash = array(
            3 => 0,
            2 => 0,
            1 => ($fileSize >> 16) & 0xFFFF,
            0 => $fileSize & 0xFFFF
        );
        $hash = $this->read8Kb($handle, $hash);
        $offset = $fileSize - 65536;
        fseek($handle, $offset > 0 ? $offset : 0, SEEK_SET);
        $hash = $this->read8Kb($handle, $hash);
        fclose($handle);
        return $this->uINT64FormatHex($hash);
    }

    /**
     * @param $handle
     * @return array
     */
    private function readUINT64($handle)
    {
        $unpack = unpack("va/vb/vc/vd", fread($handle, 8));
        return array(0 => $unpack["a"], 1 => $unpack["b"], 2 => $unpack["c"], 3 => $unpack["d"]);
    }

    /**
     * @param $a
     * @param $b
     * @return array
     */
    private function addUINT64($a, $b)
    {
        $o = array(0 => 0, 1 => 0, 2 => 0, 3 => 0);
        $carry = 0;
        for ($i = 0; $i < 4; $i++) {
            if (($a[$i] + $b[$i] + $carry) > 0xffff) {
                $o[$i] += ($a[$i] + $b[$i] + $carry) & 0xffff;
                $carry = 1;
            } else {
                $o[$i] += ($a[$i] + $b[$i] + $carry);
                $carry = 0;
            }
        }
        return $o;
    }

    /**
     * @param $n
     * @return string
     */
    private function uINT64FormatHex($n)
    {
        return sprintf("%04x%04x%04x%04x", $n[3], $n[2], $n[1], $n[0]);
    }

    /**
     * @param $handle
     * @param $hash
     * @return array
     */
    private function read8Kb($handle, $hash)
    {
        for ($i = 0; $i < 8192; $i++) {
            $tmp = $this->readUINT64($handle);
            $hash = $this->addUINT64($hash, $tmp);
        }
        return $hash;
    }
}
