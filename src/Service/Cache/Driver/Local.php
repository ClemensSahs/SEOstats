<?php

namespace SeoStats\Service\Cache;

class Local extends AbstractCacheAdapter
{
    protected $cache = array();

    /**
     * @param string $key
     * @return bool
     */
    public function hasCache($key)
    {
        return isset($cache[$key]);
    }
    /**
     * @param string $key
     * @return mixed
     */
    public function getCache($key)
    {
        return $cache[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setCache($key, $value)
    {
        $cache[$key] = $value;
    }
}
