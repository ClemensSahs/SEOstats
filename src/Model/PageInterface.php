<?php

namespace SeoStats\Model;

use SeoStats\SeoStats;

interface PageInterface
{
    public function getUrl();
    public function setSeoStats(SeoStats $seoStats);
}
