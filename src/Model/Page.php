<?php

namespace SeoStats\Model;

use SeoStats\SeoStats;

class Page implements PageInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var SeoStats
     */
    protected $seoStats;


    /**
     *
     * @param string $url
     */
    public function __construct($url, SeoStats $seoStats)
    {
        $this->setUrl($url);
        $this->setSeoStats($seoStats);
    }


    /**
     *
     * @param string $url
     */
    public function __call($methodeName, $args)
    {
        if (substr($methodeName, 0, 3) != 'get') {
            throw new \RuntimeException(sprintf(
              'methode with the name "%s" is not exists in the class "%s"',
              $methodeName,
              __CLASS__
            ));
        }

        return call_user_func(array($this->getSeoStats(), $methodeName), $args);
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     *
     * @param string $url
     */
    protected function setUrl($url)
    {
        $this->guardUrlIsValid($url);

        $this->url = $this->canonicalizeUrl($url);
    }

    /**
     *
     * @param string $url
     */
    protected function guardUrlIsValid($url)
    {}

    /**
     *
     * @param string $url
     */
    protected function guardHasSeoStats()
    {
        if ($this->seoStats == null) {
            throw new \RuntimeException('...');
        }
    }

    /**
     *
     * @param string $url
     * @return string
     */
    protected function canonicalizeUrl($url)
    {
        return preg_replace('#^https?://#', '', strtolower($url));
    }

    public function setSeoStats(SeoStats $seoStats)
    {
        $this->seoStats = $seoStats;
    }

    /**
     *
     * @return SeoStats
     */
    public function getSeoStats()
    {
        $this->guardHasSeoStats();
        return $this->seoStats;
    }
}
