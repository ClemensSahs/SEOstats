<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$url = 'wikipedia.org';

$seoStats->setCacheServer('localhost:8080','mysql');
$seoStats->setCacheServer('localhost:8080','mongo');
$seoStats->setCacheServer('localhost:8080','redis');
$seoStats->setCacheServer('localhost:8080','couchdb');
$seoStats->setCacheServer('localhost:8080','intern');
$seoStats->readFromCacheServer(true);
$seoStats->writeToCacheServer(false);

$backlinks = $seoStats->get('google-backlinks', $url);
$backlinks = $seoStats->getGoogleBacklinks($url);
