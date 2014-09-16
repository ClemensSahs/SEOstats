<?php

namespace SeoStats\V3\HttpAdapter;

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
    public function setHttpAdapter(HttpAdapter $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    /**
     *
     * @return HttpAdapter
     */
    public function getHttpAdapter()
    {
        return $this->httpAdapter;
    }
}
