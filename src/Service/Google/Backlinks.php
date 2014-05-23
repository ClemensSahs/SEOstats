<?php

namespace SeoStats\Service\Google;

use SeoStats\Model\PageInterface;

class Backlinks extends AbstractGoogleApiService
{
    public function parseUrl(PageInterface $url)
    {
        return sprint($this->getUrlFormat(), urlencode("link:{$url}"), 1);
    }
}
