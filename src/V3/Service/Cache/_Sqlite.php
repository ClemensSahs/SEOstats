<?php

namespace SeoStats\V3\Service\Cache;

class Sqlite extends AbstractCacheAdapter
{
    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        throw new \RuntimeException('currently no logic');
    }
    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        throw new \RuntimeException('currently no logic');
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        throw new \RuntimeException('currently no logic');
    }
}
