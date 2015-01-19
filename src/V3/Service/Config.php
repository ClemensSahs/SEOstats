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
        $this->setArray(array(
            'google-search-api-url'=>'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz={google_rsz}&q={google_query}'
        ));
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
     * @param mixed $value
     */
    public function setArray($array)
    {
        foreach ( $array as $key=>$value) {
            $this->set($key, $value);
        }
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

    /**
     *
     * @param string $key
     * @return bool
     */
    public function guardHasKeys(array $keys)
    {
        foreach ($keys as $key) {
            if ($this->has($key)) {
                continue;
            }

            throw new \RuntimeException(sprintf("don't have a key called '%s'",
                                                $key
                                        ));
        }
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        return $this->config;
    }
}
