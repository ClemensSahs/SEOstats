<?php

namespace SeoStats\V3\Model;

use SeoStats\V3\SeoStats;

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
    {
        if(!isset($url) || 1 > strlen($url)) {
            throw new \RuntimeException(sprintf('given string "%s" is to short to be a valid URL', $url));
        }

        $parstedData = $this->parseUrl($url);

        var_dump($parstedData, ! $parstedData['host'], !$parstedData['scheme']);

        if (! $parstedData['host'] && !$parstedData['scheme']) {
            throw new \RuntimeException(sprintf('given string "%s" is not a valid URL', $url));
        }
    }

    protected function isValidUrl($url)
    {
        if(!isset($url) || 1 > strlen($url)) {
            return false;
        }

        $parstedData = $this->parseUrl($url);

        return (bool) ($parstedData['host'] &&
                       $parstedData['scheme'] &&
                       $this->isValidUrlRfc($url));
    }

    protected function isValidUrlRfc($url)
    {
        $pattern  = '([A-Za-z][A-Za-z0-9+.-]{1,120}:[A-Za-z0-9/](([A-Za-z0-9$_.+!*,;/?:@&~=-])';
        $pattern .= '|%[A-Fa-f0-9]{2}){1,333}(#([a-zA-Z0-9][a-zA-Z0-9$_.+!*,;/?:@&~=%-]{0,1000}))?)';
        return (bool) preg_match($pattern, $url);
    }


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
