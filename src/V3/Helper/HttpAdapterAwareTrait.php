<?php

namespace SeoStats\V3\Helper;

trait HttpAdapterAwareTrait
{
    /**
     *
     * @var HttpAdapter
     */
    protected $httpAdapter;

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
}
