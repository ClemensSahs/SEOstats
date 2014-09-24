<?php

namespace SeoStats\V3\Service\Cache;

class Local extends AbstractCacheAdapter
{
    protected $cache = array();

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->cache[$key]);
    }
    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->cache[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->cache[$key] = $value;
        return true;
    }
}
