<?php

namespace SeoStats\V3\Service;

interface ConfigAwareInterface
{
    /**
     *
     * @param Config $config
     */
    public function setConfig(Config $config);

    /**
     *
     * @return Config
     */
    public function getConfig();
}
