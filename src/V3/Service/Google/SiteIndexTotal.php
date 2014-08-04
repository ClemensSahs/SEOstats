<?php

namespace SeoStats\V3\Service\Google;

use SeoStats\V3\Model\PageInterface;

class SiteIndexTotal extends AbstractGoogleApiService
{
    public function parseUrl(PageInterface $url)
    {
        return sprint($this->getUrlFormat(), urlencode("site:" . $url), 1);
    }
}
