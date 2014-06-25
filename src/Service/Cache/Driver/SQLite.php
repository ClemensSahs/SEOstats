<?php

namespace SeoStats\Service\Cache;

class SQLite extends AbstractCacheAdapter
{
    /**
     * @param string $key
     * @return bool
     */
    public function hasCache($key)
    {
        throw new \RuntimeException('currently no logic');
    }
    /**
     * @param string $key
     * @return mixed
     */
    public function getCache($key)
    {
        throw new \RuntimeException('currently no logic');
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setCache($key, $value)
    {
        throw new \RuntimeException('currently no logic');
    }
}
