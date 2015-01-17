<?php

namespace SeoStatsV3Test\Service\Asset;

use SeoStats\V3\Service\AbstractService;
use SeoStats\V3\Service\ConfigAwareInterface;
use SeoStats\V3\Service\ConfigAwareTrait;
use SeoStats\V3\HttpAdapter\HttpAdapterAwareInterface;
use SeoStats\V3\HttpAdapter\HttpAdapterAwareTrait;

class CustomService
    extends AbstractService
    implements ConfigAwareInterface, HttpAdapterAwareInterface
{
    use ConfigAwareTrait;
    use HttpAdapterAwareTrait;

    public function __construct ()
    {
        parent::__construct();
    }
}
