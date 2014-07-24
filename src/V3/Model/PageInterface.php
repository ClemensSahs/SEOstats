<?php

namespace SeoStats\V3\Model;

use SeoStats\V3\SeoStats;

interface PageInterface
{
    public function getUrl();
    public function setSeoStats(SeoStats $seoStats);
}
