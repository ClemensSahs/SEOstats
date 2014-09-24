<?php
namespace SEOstats\V3\Model;

/**
 * URL-String Helper Class
 *
 * @package    SEOstats
 * @author     Stephan Schmitz <eyecatchup@gmail.com>
 * @copyright  Copyright (c) 2010 - present Stephan Schmitz
 * @license    http://eyecatchup.mit-license.org/  MIT License
 * @updated    2013/02/03
 */

use SeoStats\V3\Model\Exception\UrlIsToShortException;
use SeoStats\V3\Model\Exception\UrlIsNotValidException;

class Url
{
    /**
     * @var string
     */
    protected static $canonicalUrls = array();

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $originUrl;

    /**
     * @var bool
     */
    protected $isValid = true;

    /**
     * @var array
     */
    protected $parsedUrl;

    public function __construct($url)
    {
        $this->setUrl($url);
    }

    public function getUrl($orign = false)
    {
        if ($orign) {
            return $this->originUrl;
        }

        if (! isset($this->url)) {
            $this->buildUrlFromParsed();
        }
        return $this->url;
    }

    protected function buildUrlFromParsed()
    {
        $this->url = strtolower(sprintf('%s://%s%s',
                             $this->getScheme(),
                             $this->getHost(),
                             $this->getPath()
                         ));
    }

    public function getHost()
    {
        $this->gurardUrlIsValid();
        return $this->parsedUrl['host'];
    }

    public function getScheme()
    {
        $this->gurardUrlIsValid();
        return $this->parsedUrl['scheme'];
    }

    public function getPath()
    {
        $this->gurardUrlIsValid();
        return isset($this->parsedUrl['path']) ? $this->parsedUrl['path'] : '';
    }

    public function isValid()
    {
        return (bool) $this->isValid;
    }

    protected function gurardUrlIsValid()
    {
        if (!$this->isValid()) {
            throw new UrlIsNotValidException(sprintf('url "%s" was not be valid', $this->getUrl(true)));
        }
    }

    /**
     *
     * @throw UrlIsNotValidException
     * @throw UrlIsToShortException
     */
    protected function setUrl($url)
    {
        if(isset($url) && 2 > strlen($url)) {
            throw new UrlIsToShortException(sprintf('given string "%s" is to short', $url));
        }

        $this->originUrl = $url;
        $this->cleanUrl();

        $this->gurardUrlIsValid();
    }

    protected function cleanUrl()
    {
        $this->parsedUrl = $this->parseUrl();

        $this->isValid = $this->validUrl();
    }

    protected function parseUrlToArray()
    {
        $url = preg_replace('#^([^:/?]+://)?#', 'http://', $this->originUrl);
        $parsedUrl = @parse_url($url);

        if (!is_array($parsedUrl)) {
            $parsedUrl = array(
                'host'=>false,
                'scheme'=>false,
                'path'=>false
            );
        }

        return $parsedUrl;
    }

    protected function parseUrl()
    {
        $parsedUrl = $this->parseUrlToArray();

        if (empty($parsedUrl['host'])) {
            $parsedUrl['host'] = false;
        }

        if ($parsedUrl['scheme'] != 'http' ) {
            $parsedUrl['scheme'] = false;
        }

        return $parsedUrl;
    }

    public function validUrl()
    {
        if (!$this->parsedUrl['scheme'] ||
            !$this->parsedUrl['host']
        ) {
            return false;
        }

        return true;

        // rfc url controll
        // $pattern  = '([A-Za-z][A-Za-z0-9+.-]{1,120}:[A-Za-z0-9/](([A-Za-z0-9$_.+!*,;/?:@&~=-])';
        // $pattern .= '|%[A-Fa-f0-9]{2}){1,333}(#([a-zA-Z0-9][a-zA-Z0-9$_.+!*,;/?:@&~=%-]{0,1000}))?)';
        // return (bool) preg_match($pattern, $this->getUrl());
    }

    public static function canonicalizeUrl($url)
    {
        if (isset(static::$canonicalUrls[$url])) {
            return static::$canonicalUrls[$url];
        }

        $urlObject = new static($url);
        static::$canonicalUrls[$url] = $urlObject->getUrl();

        return static::$canonicalUrls[$url];
    }
}
