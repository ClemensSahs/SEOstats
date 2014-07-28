<?php

namespace SEOstatsV3Test\Model;

use SeoStats\V3\Model\Page;
use SeoStats\V3\SeoStats;

class PageTest extends AbstractModelTestCase
{
    public function setup()
    {
        parent::setup();

    }

    /**
     * @dataProvider providerTestCreatePage
     * @group v3
     * @group model
     * @group model-page
     */
    public function testCreatePage ($url)
    {
        $seoStats = new SeoStats();
        $this->SUT = new Page($url, $seoStats);
    }

    public function providerTestCreatePage ()
    {
        return array(
            array('github.com'),
            array('github.com/path/file?queryKey=queryValue'),
            array('http://github.com'),
            array('http://github.com/path/file?queryKey=queryValue'),
            array('https://ssl.github.com'),
            array('https://ssl.github.com/path/file?queryKey=queryValue'),
            array('ftp://github.com'),
            array('ssh://github.com'),

            array('http://')
        );
    }
}
