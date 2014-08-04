<?php

namespace SeoStats\V3\Model;

use SeoStats\V3\SeoStats;
use SeoStats\V3\Model\Exception\UrlIsNotValidException;
use SeoStats\V3\Model\Exception\SeoStatsIsNotDefinedException;
use SeoStats\V3\Model\Exception\PageObjectOnlySupportDynamicGetterException;


class Page implements PageInterface
{
    /**
     * @var Url
     */
    protected $url;

    /**
     * @var SeoStats
     */
    protected $seoStats;


    /**
     *
     * @param string $url
     * @param SeoStats $seoStats = null
     */
    public function __construct($url, SeoStats $seoStats = null)
    {
        $this->setUrl($url);
        if ($seoStats) {
            $this->setSeoStats($seoStats);
        }
    }


    /**
     *
     * @param string $url
     */
    public function __call($methodName, $args)
    {
        if (substr($methodName, 0, 3) != 'get') {
            throw new PageObjectOnlySupportDynamicGetterException(sprintf(
              'methode with the name "%s" is not exists in the class "%s"',
              $methodName,
              __CLASS__
            ));
        }

        $args = array_merge(array($this), $args);

        return call_user_func(array($this->getSeoStats(), $methodName), $args);
    }

    /**
     *
     * @return Url
     */
    public function getUrl()
    {
        return $this->url->getUrl();
    }

    /**
     *
     * @return Url
     */
    public function getUrlObject()
    {
        return $this->url;
    }

    /**
     *
     * @throws UrlIsNotValidException
     * @param string|Url $url
     */
    protected function createUrl($url)
    {
        if (is_string($url)) {
            return new Url($url);
        }

        if (!$url instanceof Url) {
            throw new UrlIsNotValidException("given url is invalid");
        }

        return $url;
    }

    /**
     *
     * @param string|url $url
     */
    protected function setUrl($url)
    {
        $urlOjbect = $this->createUrl($url);

        $this->url = $urlOjbect;
    }

    /**
     *
     * @throws SeoStatsIsNotDefinedException
     */
    protected function guardHasSeoStats()
    {
        if ($this->seoStats == null) {
            throw new SeoStatsIsNotDefinedException('Page object need \SeoStats\V3\SeoStats object');
        }
    }

    /**
     *
     * @param SeoStats $seoStats
     */
    public function setSeoStats(SeoStats $seoStats)
    {
        $this->seoStats = $seoStats;
    }

    /**
     *
     * @throws SeoStatsIsNotDefinedException
     * @return SeoStats
     */
    public function getSeoStats()
    {
        $this->guardHasSeoStats();
        return $this->seoStats;
    }
}
