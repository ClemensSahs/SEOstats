<?php

namespace SeoStats\V3\Service;

use SeoStats\V3\Service\Exception\FactoryIsNotValidException;

class Manager
{
    use ConfigAwareTrait;

    protected $services = array();
    protected $defaultFactory = array();
    protected $serviceFactoryClassMap = array();
    protected $serviceFactory = array();


    protected function getFactory($serviceName)
    {
        if ($this->hasFactory($serviceName)) {
            $factory = $this->serviceFactory[$serviceName];

        } elseif ($this->hasFactoryDefined($serviceName)) {
            $factory = $this->createFactory($serviceName);
        } else {
            $factory = $this->getDefaultFacotry();
        }

        return $factory;
    }

    protected function setFactory($factory, $serviceNameList)
    {
        $this->guardFactoryIsValid($factory);

        if (!is_array($serviceNameList)) {
            $serviceNameList = array($serviceNameList);
        }

        foreach ($serviceNameList as $serviceName) {
            $this->serviceFactory[$serviceName] = $factory;
        }

        return $this;
    }

    protected function createFactory($serviceName)
    {
        if(! $this->hasFactoryDefined($serviceName) ) {
            $message = sprintf("Failing to create factory for service '%s'",
                               $serviceName);

            throw new CanNotCreateFactoryException($message);
        }

        $factoryClass = $this->serviceFactoryClassMap[$serviceName];

        $factory = new $factoryClass();

        $this->setFactory($factory, $serviceName);

        return $factory;
    }

    protected function hasFactoryDefined($serviceName)
    {
        return isset($this->serviceFactoryClassMap[$serviceName]);
    }

    protected function hasFactory($serviceName)
    {
        return isset($this->serviceFactory[$serviceName]);
    }

    protected function getDefaultFactory()
    {
        if ($this->defaultFactory !== null) {
            $this->setDefaultFactory();
        }

        return $this->defaultFactory;
    }
    protected function setDefaultFactory(AbstractService $defaultFactory = null)
    {
        if ($defaultFactory === null) {
            $defaultFactory = new DefaultFactory();
        }
        $this->defaultFactory = $defaultFactory;

        return $this;
    }

    protected function createService($serviceName)
    {
        $factory = $this->getFactory($serviceName);

        if (is_object($factory)) {
            $service = $factory->createService($serviceName);
        }  elseif (is_callable($factoryClassOrCallback)) {
            $service = $factoryClassOrCallback;
        } else {
            $message = sprintf("factory are not a Callable or valid class for service %s",
                               $serviceName);
        }

        $this->set($serviceName, $service);

        return $service;
    }

    /**
     *
     * @param string $serviceName
     * @return AbstractService
     */
    public function get($serviceName)
    {
        if (! $this->has($serviceName)) {
            $this->createService($serviceName);
        }

        return $this->services[$serviceName];
    }

    /**
     *
     * @param string $serviceName
     * @return AbstractService
     */
    public function set($serviceName, AbstractService $service)
    {
        $this->services[$serviceName] = $service;
    }

    /**
     *
     * @param string $serviceName
     * @return bool
     */
    public function has($serviceName)
    {
        return isset($this->services[$serviceName]);
    }

    public function guardFactoryIsValid ($factory)
    {
        if ($factory instanceof AbstractFactory) {
            return;
        }
        if (is_callable($factory)) {
            return;
        }

        throw new FactoryIsNotValidException();
    }
}
