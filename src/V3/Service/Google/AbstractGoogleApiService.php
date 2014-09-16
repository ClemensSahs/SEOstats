<?php

namespace SeoStats\V3\Service\Google;

use SeoStats\V3\Helper\Json;
use SeoStats\V3\Service\Config;
use SeoStats\V3\Model\PageInterface;

abstract class AbstractGoogleApiService extends AbstractGoogleService
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
        $this->setUrlFormat($config->get('google-search-api-url'));
    }

    /**
     *
     * @param string $url
     * @return mixed
     */
    public function call(PageInterface $url)
    {
        return $this->getSearchResultsTotal($url);
    }

    /**
     *  Returns total amount of results for any Google search,
     *  requesting the deprecated Websearch API.
     *
     *  @param    string    $url    String, containing the query URL.
     *  @return   integer           Returns the total search result count.
     */
    public function getSearchResultsTotal(PageInterface $url)
    {
        if ($this->hasCache($url)) {
            return $this->getCache($url);
        }

        $this->getHttpClient()->setHttpMethod('post')
                              ->setUrl($this->getUrlFormat());

        $this->parseUrl($url);

        $res = $this->getHttpClient()->send();

        if ($res->getStatusCode() === 200);

        $obj = Json::decode($res->getBody(true));

        return !isset($obj->responseData->cursor->estimatedResultCount)
            ? $this->getNoData()
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
    abstract public function parseUrl(PageInterface $url);
}
