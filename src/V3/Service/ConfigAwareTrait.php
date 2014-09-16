<?php

namespace SeoStats\V3\Service;

trait ConfigAwareTrait
{
    /**
     *
     * @var Config
     */
    protected $config;

    /**
     *
     * @param Config $httpAdapter
     */
    protected function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     *
     * @return Config
     */
    protected function getConfig()
    {
        return $this->config;
    }
}
