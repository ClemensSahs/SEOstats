<?php

namespace SeoStats\V3\Service\Google;

use SeoStats\V3\Model\PageInterface;

class Backlinks extends AbstractGoogleApiService
{
    public function parseUrl(PageInterface $url)
    {
        $this->getHttpAdapter()->setVariable(array(
            'google_query'=> urlencode("link:" . $url->getUrl()),
            'google_rsz'=> 1
        ));
    }
}
