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
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
