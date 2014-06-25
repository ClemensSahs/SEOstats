<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$pageObject = $seoStats->createPageObject('wikipedia.org');

$backlinks = $seoStats->get('google-backlinks', $pageObject); // 1st call
$backlinks = $seoStats->getGoogleBacklinks($pageObject);      // no call get from cache

$seoStats->disableLocalCache();

$backlinks = $seoStats->get('google-backlinks', $pageObject); // 2nd call
$backlinks = $seoStats->getGoogleBacklinks($pageObject);      // 3rd call
