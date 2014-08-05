<?php

namespace SEOstatsV3Test\Model;

use SeoStats\V3\SeoStats;
use SeoStats\V3\Model\PageList;
use SeoStats\V3\Model\Page;

class PageListTest extends AbstractModelTestCase
{
    protected $seoStats;


    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->seoStats = new SeoStats();
    }

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
    public function testCreatePageListWithConstruct ($args, $assertStatus)
    {
        $SUT = new PageList($args[0], $args[1]);

        $this->assertInstanceOf('SeoStats\V3\SeoStats', $SUT->getSeoStats());

        foreach ($SUT as $pageKey=>$page) {
            $this->assertInstanceOf('SeoStats\V3\Model\Page', $page);
        }

        $this->assertEquals($assertStatus, $SUT->count());
    }

    /**
     * @dataProvider providerTestCreatePageList
     * @group v3
     * @group model
     * @group model-page-list
     */
    public function testCreatePageListWithAddArray ($args, $assertStatus)
    {
        $SUT = new PageList($args[0]);

        $SUT->addArray($args[1]);

        $this->assertInstanceOf('SeoStats\V3\SeoStats', $SUT->getSeoStats());

        $this->assertEquals($assertStatus, $SUT->count());
    }

    /**
     * @dataProvider providerTestCreatePageList
     * @group v3
     * @group model
     * @group model-page-list
     */
    public function testCreatePageListWithAddSingle ($args, $assertStatus)
    {
        $SUT = new PageList($args[0]);

        foreach ($args[1] as $page) {
            $SUT->add($page);
        }

        $this->assertInstanceOf('SeoStats\V3\SeoStats', $SUT->getSeoStats());

        $this->assertEquals($assertStatus, $SUT->count());
    }

    /**
     * @group v3
     * @group model
     * @group model-page-list
     */
    public function testRemoveAndFindPage ()
    {
        $pages = array(
            'github.com',
            'google.com',
            'localhost.local'
        );

        $SUT = new PageList($this->seoStats, $pages);

        $this->assertEquals(3,$SUT->count());
        $this->assertTrue($SUT->hasPage('localhost.local'));
        $SUT->remove('localhost.local');
        $this->assertFalse($SUT->hasPage('localhost.local'));


        $page = $SUT->findPage('github.com');

        $this->assertEquals(2,$SUT->count());
        $SUT->remove($page);
        $this->assertEquals(1,$SUT->count());

        $this->assertNull($SUT->findPage('github.com'));
    }

    public function helperCreatePageArray ($source, $seoStats = null)
    {
        $result = array();

        foreach ($source as $url) {
            $result[]=new Page($url);
        }

        return $result;
    }

    public function providerTestCreatePageList()
    {

        $results = array();

        $pages = array(
            'github.com',
            'google.com',
            'google.com'
        );


        $args = array($this->seoStats, $pages);
        $results[] = array($args, 2);

        $args = array($this->seoStats, array_merge(array('localhost.local'),
                                             $this->helperCreatePageArray($pages)));
        $results[] = array($args, 3);

        $args = array($this->seoStats, $this->helperCreatePageArray($pages));
        $results[] = array($args, 2);

        $args = array($this->seoStats, $this->helperCreatePageArray($pages, $this->seoStats));
        $results[] = array($args, 2);

        return $results;
    }
}
