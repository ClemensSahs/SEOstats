<?php

use SeoStats\SeoStats;
use SeoStats\Model\PageList;

$seoStats = new SeoStats();

$url= array();
$url[] = 'wikipedia.org';
$url[] = 'php.net';
$url[] = 'stackoverflow.com';

$pageObjects = new PageList($url, $seoStats);

foreach ($pageObjects as $page) {
    echo $page->getGoogleBacklinks(); // backlinks by google as integer
}

$result = $pageObjects->getGoogleBacklinks();

echo $result['wikipedia.org']; // backlinks by google as integer
