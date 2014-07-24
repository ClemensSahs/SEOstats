<?php

namespace SeoStats\V3\Service\Google;

class Backlinks extends AbstractGoogleApiService
{
    public function parseUrl($url)
    {
        return sprint($this->getUrlFormat(), urlencode("site:" . $url), 1);
    }
}
