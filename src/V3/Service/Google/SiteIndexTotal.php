<?php

namespace SeoStats\V3\Service\Google;

use SeoStats\V3\Model\PageInterface;

class SiteIndexTotal extends AbstractGoogleApiService
{
    public function parseUrl(PageInterface $url)
    {
        $this->getHttpAdapter()->setVariable(array(
            'google_site_filter'=> $url->getUrl(),
            'google_query'=> ""
        ));
    }
}
