<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$url= array();
$url[] = 'wikipedia.org';
$url[] = 'php.net';
$url[] = 'stackoverflow.com';

$backlinks = $seoStats->get('google-backlinks', $url);
$backlinks = $seoStats->getGoogleBacklinks($url);
