<?php

use SeoStats\SeoStats;

$seoStats = new SeoStats();

$url = 'wikipedia.org';

$seoStats->setConfig('facebook-api-key',md5('secret'));
$seoStats->setConfig('google-api-key',md5('secret'));
$seoStats->setConfig('google-webmastertools-user',md5('secret'));
$seoStats->setConfig('google-webmastertools-password',md5('secret'));

$shares = $seoStats->get('facebook-shares', $url); // 1st call
$backlinks = $seoStats->get('google-backlinks-webmastertools', $url); // 1st call
