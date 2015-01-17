<?php

namespace SeoStats\V3\Service;

use SeoStats\V3\HttpAdapter;
use SeoStats\V3\SeoStats;

abstract class AbstractService
{
    public function __construct ()
    {}

    public function getNoData()
    {
        return SeoStats::$NO_DATA;
    }
}
