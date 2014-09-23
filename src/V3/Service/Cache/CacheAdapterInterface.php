<?php

namespace SeoStats\V3\Service\Cache;

interface CacheAdapterInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has($key);
    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);
}
