<?php

namespace Helpers;

trait FixtureAware
{
    /**
     * @param string $fileName
     * @return string
     */
    public function getFixturePathByName($fileName)
    {
        $fixturePath = __DIR__ . '/../fixtures/' . $fileName;
        if (!file_exists($fixturePath)) {
            throw new \InvalidArgumentException(sprintf('Invalid fixture name "%s" given', $fileName));
        }
        return $fixturePath;
    }

    /**
     * @param $fileName
     * @return string
     */
    public function getFixtureByName($fileName)
    {
        $fixturePath = $this->getFixturePathByName($fileName);
        $fixture = file_get_contents($fixturePath);
        if ($fixture === false) {
            throw new \RuntimeException('Unable to open fixture "%s"', $fixturePath);
        }
        return $fixture;
    }
}
