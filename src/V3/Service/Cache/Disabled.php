<?php

namespace SeoStats\V3\Service\Cache;

class Disabled extends AbstractCacheAdapter
{
    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return false;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        return false;
    }
}
