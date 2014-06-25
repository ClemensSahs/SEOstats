<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$url = 'wikipedia.org';

$pageObject1 = $seoStats->createPageObject($url);
$pageObject1->getGoogleBacklinks();               // 1st call


$pageObject2 = new Page($url, $seoStats);
$pageObject2->getGoogleBacklinks();               // no call, load from cache



$pageObject1->disableLocalCache();                // only for this object

$pageObject1->getGoogleBacklinks();               // 2st call
$pageObject1->getGoogleBacklinks();               // 3st call
$pageObject2->getGoogleBacklinks();               // no call, load from cache

$seoStats->disableLocalCache();                   // for all objects
$pageObject1->getGoogleBacklinks();               // 4st call
$pageObject2->getGoogleBacklinks();               // 5st call
