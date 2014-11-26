<?php

namespace SeoStats\V3\Service\Google;

use SeoStats\V3\Model\PageInterface;

class BacklinkViaWebmasterTools extends AbstractGoogleService
{
    public function call(PageInterface $url)
    {
        throw new \RuntimeException(sprintf('%s not implementet', __METHOD__));
    }
}
