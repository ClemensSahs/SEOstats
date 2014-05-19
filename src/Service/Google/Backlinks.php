<?php

namespace SeoStats\Service\Google;

class Backlinks extends AbstractGoogleApiService
{
    public function parseUrl($url)
    {
        return sprint($this->getUrlFormat(), urlencode("link:{$url}"), 1);
    }
}
