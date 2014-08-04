<?php

namespace SeoStats\V3\Service;

use SeoStats\V3\Helper\HttpAdapter;

abstract class AbstractService
{
    // if we use only php5.4
    // use \SeoStats\Helper\HttpAdapterAwareTrait

    /**
     *
     * @var HttpAdapter
     */
    protected $httpAdapter;

    /**
     *
     * @var Config
     */
    protected $config;

    /**
     *
     * @param HttpAdapter $httpAdapter
     */
    protected function setHttpAdapter(HttpAdapter $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    /**
     *
     * @return HttpAdapter
     */
    protected function getHttpAdapter()
    {
        return $this->httpAdapter;
    }

    /**
     *
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}
