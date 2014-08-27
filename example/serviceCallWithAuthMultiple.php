<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$authData = array(
    'wikipedia.org'=>array('user'=>md5('secret'),'password'=>md5('secret')),
    'github.com'=>array('user'=>md5('secret'),'password'=>md5('secret')),
    'stackoverflow.com'=>array('user'=>md5('secret'),'password'=>md5('secret')),
);

$pageListObject = $seoStats->createPageListObject(array_keys($authData));

$seoStats->setConfig('google-webmastertools-array', $authData);

$backlinksResult = $seoStats->get('google-backlinks-webmastertools', $pageListObject); // n calls
$backlinksResult = $seoStats->getGoogleBacklinksWebmastertools($pageListObject); // no request calls
