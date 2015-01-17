<?php

namespace SeoStats\V3\HttpAdapter;

interface HttpAdapterAwareInterface
{
    /**
     *
     * @param HttpAdapterInterface $httpAdapter
     */
    public function setHttpAdapter(HttpAdapterInterface $httpAdapter);

    /**
     *
     * @return HttpAdapterInterface
     */
    public function getHttpAdapter();
}
