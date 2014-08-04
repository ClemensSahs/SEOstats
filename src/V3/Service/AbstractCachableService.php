<?php

namespace SeoStats\V3\Service;

use SeoStats\V3\Service\CacheAdapter;

abstract class AbstractCachableService extends AbstractService
{
    /**
     *
     * @var CacheAdapter
     */
    protected $cacheAdapter;

    /**
     *
     * @return bool
     */
    protected function hasCache($url)
    {
        return $this->getCacheAdapter()->has($url);
    }

    /**
     *
     * @return mixed
     */
    protected function getCache($url)
    {
        return $this->getCacheAdapter()->get($url);
    }

    /**
     *
     * @param string $url
     * @param mixed $value
     */
    protected function setCache($url, $value)
    {
        $this->getCacheAdapter()->set($url, $value);
    }

    /**
     * @param CacheAdapter $cacheAdapter
     */
    public function setCacheAdapter(CacheAdapter $cacheAdapter)
    {
        $this->cacheAdapter = $cacheAdapter;
    }

    /**
     * this methode return a CacheAdapter, if this is null this service don't will cached
     *
     * @return CacheAdapter|null
     */
    protected function getCacheAdapter()
    {
        return $this->cacheAdapter;
    }

    /**
     * this methode return a CacheAdapter, if this is null this service don't will cached
     *
     * @return CacheAdapter|null
     */
    protected function hasCacheAdapter()
    {
        return isset($this->cacheAdapter);
    }
}
