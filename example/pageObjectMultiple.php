<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$url= array();
$url[] = 'wikipedia.org';
$url[] = 'php.net';
$url[] = 'stackoverflow.com';

$pageObjects = $seoStats->createPageObject($url, true);

foreach ($pageObjects as $page) {
    $page->getGoogleBacklinks();
}
