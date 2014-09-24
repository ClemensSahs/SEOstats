<?php

namespace SeoStats\V3\HttpAdapter;

trait HttpAdapterAwareTrait
{
    /**
     *
     * @var HttpAdapterInterface
     */
    protected $httpAdapter;

    /**
     *
     * @param HttpAdapterInterface $httpAdapter
     */
    public function setHttpAdapter(HttpAdapterInterface $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    /**
     *
     * @return HttpAdapterInterface
     */
    public function getHttpAdapter()
    {
        return $this->httpAdapter;
    }
}
