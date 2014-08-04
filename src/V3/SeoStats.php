<?php

namespace SeoStats\V3;

use SeoStats\V3\Service\Config;
use SeoStats\V3\Service\Manager;

class SeoStats
{
    public static $NO_DATA = 'n.a.';
    protected static $pageClass = 'SeoStats\V3\Model\Page';
    protected static $pageListClass = 'SeoStats\V3\Model\PageList';

    /**
     *
     * @var Manager
     */
    protected $manager;

    /**
     *
     * @var Config
     */
    protected $config;

    public static function setNodataValue($data)
    {
        self::$NO_DATA = $data;
    }

    /**
     *
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     *
     * @return Config
     */
    public function getConfig()
    {
        if (!isset($this->config)) {
            $this->config = new Config();
        }

        return $this->config;
    }

    /**
     *
     * @param Manager $config
     */
    public function setServiceManager(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     *
     * @return Manager
     */
    public function getServiceManager()
    {
        return $this->manager;
    }

    public function get($serviceName, $url)
    {
        if (! $url instanceof PageInterface) {
            return $this->getWithList($serviceName, $url);
        }

        return $this->getServiceManager()->get($serviceName)->call($url);
    }

    public function getWithList($serviceName, PageListInterface $pageList)
    {
        $service = $this->getServiceManager()->get($serviceName);

        $response = array();
        foreach ($pageList as $page) {
            $response[$page->getUrl()] = $service->call($url);
        }

        return $response;
    }

    public function createPageObject($url)
    {
        $class = static::$pageClass;
        $page = new $class($url, $this);
        return $page;
    }

    public function createPageListObject(array $urlList)
    {
        $class = static::$pageListClass;
        $page = new $class($urlList, $this);
        return $page;
    }

    public function __call($methodeName, $args)
    {


    }
}
