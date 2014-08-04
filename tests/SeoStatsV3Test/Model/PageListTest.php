<?php

namespace SEOstatsV3Test\Model;

use SeoStats\V3\SeoStats;
use SeoStats\V3\Model\PageList;
use SeoStats\V3\Model\Page;

class PageListTest extends AbstractModelTestCase
{
    public function setup()
    {
        parent::setup();

    }

    /**
     * @dataProvider providerTestCreatePageList
     * @group v3
     * @group model
     * @group model-page-list
     */
    public function testCreatePageList1 ($args, $assertStatus)
    {
        $SUT = new PageList($args[0], $args[1]);

        $this->assertInstanceOf('SeoStats\V3\SeoStats', $SUT->getSeoStats());
    }

    /**
     * @dataProvider providerTestCreatePageList
     * @group v3
     * @group model
     * @group model-page-list
     */
    public function testCreatePageList3 ($args, $assertStatus)
    {
        $SUT = new PageList($args[0]);

        $SUT->addArray($args[1]);

        $this->assertInstanceOf('SeoStats\V3\SeoStats', $SUT->getSeoStats());
    }

    /**
     * @dataProvider providerTestCreatePageList
     * @group v3
     * @group model
     * @group model-page-list
     */
    public function testCreatePageList4 ($args, $assertStatus)
    {
        $SUT = new PageList($args[0]);

        foreach ($args[1] as $page) {
            $SUT->add($page);
        }

        $this->assertInstanceOf('SeoStats\V3\SeoStats', $SUT->getSeoStats());
    }

    public function helperCreatePageArray ($source, $seoStats = null)
    {
        $result = array();

        foreach ($source as $url) {
            $result[]=new Page($url);
        }

        return $result;
    }

    public function providerTestCreatePageList ()
    {
        $seoStats = new SeoStats();

        $results = array();

        $pages = array(
            'github.com',
            'google.com'
        );


        $args = array($seoStats, $pages);
        $results[] = array($args, true);

        $args = array($seoStats, $this->helperCreatePageArray($pages));
        $results[] = array($args, true);

        $args = array($seoStats, $this->helperCreatePageArray($pages, $seoStats));
        $results[] = array($args, true);

        return $results;
    }
}
