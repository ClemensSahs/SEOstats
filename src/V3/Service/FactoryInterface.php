<?php

namespace SeoStats\V3\Service;

interface FactoryInterface
{
    public function createService($serviceName);

    /**
     *
     * @param string $serviceName
     * @throws Exception\CanNotCreateServiceException
     */
    public function guardCanCreateService($serviceName);

    /**
     *
     * @param string $service
     * @throws Exception\CanNotCreateServiceException
     */
    public function guardValidService($service);
}
