<?php

namespace SeoStats\V3\Service;

class Config
{
    protected $config = array();

    /**
     *
     */
    public function __construct()
    {
        $this->config = array(
            'google-search-api-url'=>'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz={google_rsz}&q={google_query}'
        );
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->config[$key];
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->config[$key]);
    }
}
