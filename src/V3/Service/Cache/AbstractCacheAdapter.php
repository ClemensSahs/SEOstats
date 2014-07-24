<?php

namespace SeoStats\V3\Service\Cache;

use SeoStats\V3\Service\AdapterService;

class AbstractCacheAdapter extends AdapterService
{
    /**
     * @param string $key
     * @return bool
     */
    abstract public function hasCache($key);
    /**
     * @param string $key
     * @return mixed
     */
    abstract public function getCache($key);

    /**
     * @param string $key
     * @param mixed $value
     */
    abstract public function setCache($key, $value);
}
