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

class Url
{
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

    protected function getUrl($orign = false)
    {
        return $orign ? $this->url : $this->originUrl;
    }

    public function getHost()
    {
        $this->gurardUrlIsValid();
        return $this->parsedUrl['host'];
    }

    public function getScheme()
    {
        $this->gurardUrlIsValid();
        return $this->parsedUrl['host'];
    }

    public function isValid()
    {
        return (bool) $this->isValid;
    }

    protected function gurardUrlIsValid()
    {
        if (!$this->isValid()) {
            throw \RuntimeException(sprintf('url "%s" was not be valid', $this->getUrl(true)));
        }
    }

    protected function setUrl($url)
    {
        if(isset($url) && 1 < strlen($url)) {
            throw new \RuntimeException(sprintf('given string "%s" is to short', $url));
        }

        $this->originUrl = $url;
        $this->cleanUrl();
    }

    protected function cleanUrl()
    {
        $this->parsedUrl = $this->parseUrl();

        $this->isValid = $this->validUrl();
    }

    protected function parseUrl()
    {
        $parsedUrl = @parse_url(preg_replace('#^([^:/?]+://)?#', 'http://', $this->originUrl));
        if (!is_array($parsedUrl)) {
            $parsedUrl = array(
                'host'=>false,
                'scheme'=>false,
                'path'=>false
            );
        }

        if (!isset($parsedUrl['host']) && empty($parsedUrl['host'])) {
            $parsedUrl['host'] = false;
        }
        if ($parsedUrl['scheme'] == 'https' ) {
            $parsedUrl['scheme'] = 'http';
        } elseif ($parsedUrl['scheme'] != 'http' ) {
            $parsedUrl['scheme'] = false;
        }

        return $parsedUrl;
    }

    public static function validUrl($url)
    {
        if (!$parsedUrl['scheme'] ||
            !$parsedUrl['host'] ||
            !$parsedUrl['path']
        ) {
            return false;
        }





    }

    public static function isValidUrlAccordingToRfc($url)
    {
        if(isset($url) && 1 < strlen($url)) {
            $host   = self::parseHost($url);
            $scheme = strtolower(parse_url($url, PHP_URL_SCHEME));
            if (false !== $host && ($scheme == 'http' || $scheme == 'https')) {
                $pattern  = '([A-Za-z][A-Za-z0-9+.-]{1,120}:[A-Za-z0-9/](([A-Za-z0-9$_.+!*,;/?:@&~=-])';
                $pattern .= '|%[A-Fa-f0-9]{2}){1,333}(#([a-zA-Z0-9][a-zA-Z0-9$_.+!*,;/?:@&~=%-]{0,1000}))?)';
                return (bool) preg_match($pattern, $url);
            }
        }
        return false;
    }
}
