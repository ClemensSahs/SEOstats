<?php

namespace SeoStats\Service\Cache;

use SeoStats\Service\AdapterService;

class CacheAdapter extends AdapterService
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
