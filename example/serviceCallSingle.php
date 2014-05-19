<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$url = 'wikipedia.org';

$backlinks = $seoStats->get('google-backlinks', $url); // 1st call
$backlinks = $seoStats->getGoogleBacklinks($url);      // no call get from cache

$seoStats->disableLocalCache();

$backlinks = $seoStats->get('google-backlinks', $url); // 2nd call
$backlinks = $seoStats->getGoogleBacklinks($url);      // 3rd call
