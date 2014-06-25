<?php

namespace SeoStats\Service\Cache;

class Disabled extends AbstractCacheAdapter
{
    /**
     * @param string $key
     * @return bool
     */
    public function hasCache($key)
    {
        return false;
    }
    /**
     * @param string $key
     * @return mixed
     */
    public function getCache($key)
    {
        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setCache($key, $value)
    {
    }
}
