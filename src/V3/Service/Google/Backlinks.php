<?php

namespace SeoStats\V3\Service\Google;

use SeoStats\V3\Model\PageInterface;

class Backlinks extends AbstractGoogleApiService
{
    public function parseUrl(PageInterface $url)
    {
        return sprint($this->getUrlFormat(), urlencode("link:{$url}"), 1);
    }
}
