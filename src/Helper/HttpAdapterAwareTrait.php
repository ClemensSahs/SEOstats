<?php

namespace SeoStats\Helper;

class HttpAdapterAwareTrait
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
