<?php

namespace SeoStats\V3\Service;

class Manager
{
    use ConfigAwareTrait;

    protected $services = array();
    protected $serviceClassMap = array(
        'google-backlinks' => '\SeoStats\V3\Service\Google\Backlinks',
        'google-siteindextotal' => '\SeoStats\V3\Service\Google\Siteindextotal',
    );

    protected function createService($key)
    {
        $this->guardCanCreateService($key);

        $class = $this->serviceClassMap[$key];
        $service = new $class();

        $service->setConfig($this->getConfig());
        $this->set($key, $service);

    }

    /**
     *
     * @param string $key
     * @throws Exception\CanNotCreateServiceException
     */
    public function guardCanCreateService($key)
    {
        if (! isset($this->serviceClassMap[$key])) {
            throw new Exception\CanNotCreateServiceException("Service is not defined");
        }

        if (! class_exists($this->serviceClassMap[$key])) {
            throw new Exception\CanNotCreateServiceException("ServiceClass is not exists or can not loaded");
        }
    }

    /**
     *
     * @param string $key
     * @return AbstractService:
     */
    public function get($key)
    {
        if (! $this->has($key)) {
            $this->createService($key);
        }

        return $this->services[$key];
    }

    /**
     *
     * @param string $key
     * @return AbstractService:
     */
    public function set($key, AbstractService $service)
    {
        $this->services[$key] = $service;
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->services[$key]);
    }
}
