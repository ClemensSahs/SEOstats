<?php

namespace SeoStats\V3\Service;

use SeoStats\V3\HttpAdapter;

abstract class AbstractFactory implements FactoryInterface, ConfigAwareInterface
{
    use ConfigAwareTrait;
    use HttpAdapter\HttpAdapterAwareTrait;

    protected $serviceFactories = array();
    protected $serviceClassMap = array();

    public function __construct ()
    {
    }

    public function addClassMap ($serviceName, $serviceClass)
    {
        $this->serviceClassMap[$serviceName] = $serviceClass;
    }
    public function addClassMapArray (array $serviceArray)
    {
        foreach ($serviceArray as $serviceName=>$serviceClass) {
            $this->addClassMap($serviceName, $serviceClass);
        }
    }

    public function createService($serviceName)
    {
        $this->guardCanCreateService($serviceName);

        $class = $this->serviceClassMap[$serviceName];
        $service = new $class();

        $this->guardValidService($service);

        $this->injectConfigIntoService($service);
        $this->injectHttpAdapterIntoService($service);

        return $service;
    }

    /**
     *
     * @param string $serviceName
     * @throws Exception\CanNotCreateServiceException
     */
    public function guardCanCreateService($serviceName)
    {
        if (! isset($this->serviceClassMap[$serviceName])) {
            throw new Exception\CanNotCreateServiceException("Service is not defined");
        }

        if (! class_exists($this->serviceClassMap[$serviceName])) {
            throw new Exception\CanNotCreateServiceException("ServiceClass is not exists or can not loaded");
        }
    }

    /**
     *
     * @param string $serviceName
     * @throws Exception\CanNotCreateServiceException
     */
    public function guardValidService($service)
    {
        if (! $service instanceof AbstractService) {
            throw new Exception\CanNotCreateServiceException("Creaded Object is not a valid Service");
        }
    }

    /**
     *
     * @param AbstractService $service
     * @return self
     */
    public function injectConfigIntoService(AbstractService $service)
    {
        if ($service instanceof ConfigAwareInterface) {
            $service->setConfig($this->getConfig());
        }

        return $this;
    }

    /**
     *
     * @param AbstractService $service
     * @return self
     */
    public function injectHttpAdapterIntoService(AbstractService $service)
    {
        if ($service instanceof HttpAdapter\HttpAdapterAwareInterface) {
            $service->setHttpAdapter($this->getHttpAdapter());
        }

        return $this;
    }


}
