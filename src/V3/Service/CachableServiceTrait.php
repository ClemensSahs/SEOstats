<?php

namespace SeoStats\V3\Service;

use SeoStats\V3\Service\Cache;


trait CachableServiceTrait
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
    public function setCacheAdapter(Cache\CacheAdapterInterface $cacheAdapter)
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
        if ($this->cacheAdapter === null) {
            $this->cacheAdapter = new Cache\Driver\Disabled();
        }

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
