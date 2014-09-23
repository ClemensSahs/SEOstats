<?php

namespace SeoStats\V3\Service;

use SeoStats\V3\HttpAdapter;
use SeoStats\V3\SeoStats;

abstract class AbstractService
{
    use HttpAdapter\HttpAdapterAwareTrait;
    use ConfigAwareTrait;

    public function getNoData()
    {
        return SeoStats::$NO_DATA;
    }
}
