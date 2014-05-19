<?php

namespace SeoStats\Service;

class Manager
{
    protected $services = array();
    protected $serviceClassMap = array(
        'google-backlinks' => '\SeoStats\Service\Google\Backlinks',
        'google-siteindextotal' => '\SeoStats\Service\Google\Siteindextotal',
    );

    protected function createService($key)
    {
        $this->guardCanCreateService($key);

        $class = $this->serviceClassMap[$key];
        $service = new $class($config);
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
     * @return multitype:
     */
    public function get($key)
    {
        if (! $this->has($key)) {
            $this->createService($key);
        }

        return $this->services[$key];
    }

    public function set($key, $service)
    {
        $this->services[$key] = $service;
    }

    public function has($key)
    {
        return isset($this->services[$key]);
    }
}
