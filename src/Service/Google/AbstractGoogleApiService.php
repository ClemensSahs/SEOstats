<?php

namespace SeoStats\Service\Google;

use SeoStats\Service\AbstractService;
use SeoStats\SeoStats;
use SeoStats\Helper\Json;
use SeoStats\Service\Config;

class AbstractGoogleApiService extends AbstractService
{
    /**
     * @var string $searchUrls
     */
    protected $searchUrls;

    /**
     *
     * @param string $url
     * @return mixed
     */
    public function __construct(Config $config)
    {
        $this->searchUrls = $config->get('google-search-api-url');
    }

    /**
     *
     * @param string $url
     * @return mixed
     */
    public function call($url)
    {
        return $this->getSearchResultsTotal($this->parseUrl($url));
    }

    /**
     *  Returns total amount of results for any Google search,
     *  requesting the deprecated Websearch API.
     *
     *  @param    string    $url    String, containing the query URL.
     *  @return   integer           Returns the total search result count.
     */
    public function getSearchResultsTotal($url)
    {
        if ($this->hasCache($url)) {
            return $this->getCache($url);
        }

        $res = $this->getHttpClient()->get($this->parseUrl($url))->send();

        if ($res->getStatusCode() === 200);

        $obj = Json::decode($res->getBody(true));

        return !isset($obj->responseData->cursor->estimatedResultCount)
            ? SeoStats::NO_DATA
            : intval($obj->responseData->cursor->estimatedResultCount);
    }

    /**
     *
     * @param string $searchUrls
     */
    public function setUrlFormat($searchUrls)
    {
        $this->searchUrls = $searchUrls;
    }

    /**
     *
     * @return string
     */
    public function getUrlFormat()
    {
        return $this->searchUrls;
    }

    /**
     *
     * @param string $url
     * @return string
     */
    abstract public function parseUrl($url);
}
