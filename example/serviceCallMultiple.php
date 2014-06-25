<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$urlList= array();
$urlList[] = 'wikipedia.org';
$urlList[] = 'php.net';
$urlList[] = 'stackoverflow.com';

$pageListObject = $seoStats->createPageObject($urlList);

$backlinks = $seoStats->get('google-backlinks', $pageListObject);

if ($backlinks == $seoStats->getGoogleBacklinks($pageListObject)) {
    // true
}
