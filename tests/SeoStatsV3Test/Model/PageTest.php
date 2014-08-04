<?php

namespace SEOstatsV3Test\Model;

use SeoStats\V3\Model\Page;
use SeoStats\V3\Model\Url;
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
    public function testCreatePage ($args, $seoStats, $assertStatus)
    {
        $isException = is_string($assertStatus) && class_exists($assertStatus);
        if ($isException) {
            $this->setExpectedException($assertStatus);
        }

        $this->SUT = new Page($args[0], $args[1]);

        if ($seoStats) {
            $this->SUT->setSeoStats($seoStats);
        }

        if (!$isException) {
            $result = $this->SUT->getUrlObject();
            $this->assertInternalType('object', $result);
            $this->assertInstanceOf('\SeoStats\V3\Model\Url', $result);

            $url = $this->SUT->getUrl();
            $this->assertInternalType('string', $url);
            $this->assertRegExp('#^http\://#', $url);
        }

        $this->assertInstanceOf('\SeoStats\V3\SeoStats', $this->SUT->getSeoStats());
    }

    /**
     * @group v3
     * @group model
     * @group model-page
     */
    public function testCall ()
    {
        $url = 'github.com';
        $mockedSeoStats = $this->getMock('SeoStats\V3\SeoStats', array('getDynamicGetterMethod'));

        $SUT = new Page($url, $mockedSeoStats);

        $args = array('arg1','arg2');

        $assertResult= (object) array();

        $mockedSeoStats->Expects($this->once())
                       ->method('getDynamicGetterMethod')
                       ->with(array($SUT, $args[0], $args[1]))
                       ->will($this->returnValue($assertResult));

        $result = $SUT->getDynamicGetterMethod($args[0], $args[1]);

        $this->assertEquals($assertResult, $result);
    }

    /**
     * @group v3
     * @group model
     * @group model-page
     */
    public function testCallFaild ()
    {
        $exception = '\SeoStats\V3\Model\Exception\PageObjectOnlySupportDynamicGetterException';
        $this->setExpectedException($exception);

        $SUT = new Page('github.com');

        $result = $SUT->methodeThatNotExists(array('arg1'));
    }

    public function providerTestCreatePage ()
    {
        $seoStats = new SeoStats();
        $exceptionSeoStats = '\SeoStats\V3\Model\Exception\SeoStatsIsNotDefinedException';
        $exceptionUrl = '\SeoStats\V3\Model\Exception\UrlIsNotValidException';



        $urlString = 'http://github.com';
        $urlObject = new Url($urlString);

        $urlStringInvalid = '//';
        $urlObjectInvalid = (object) array();

        $results = array();

        // valid
        $args = array($urlString, $seoStats);
        $results[]= array($args, null, true);

        $args = array($urlObject, $seoStats);
        $results[]= array($args, null, true);

        $args = array($urlString, null);
        $results[]= array($args, $seoStats, true);

        $args = array($urlObject, null);
        $results[]= array($args, $seoStats, true);

        // error seo stats
        $results[]= array($args, null, $exceptionSeoStats);
        $results[]= array($args, "test", '\PHPUnit_Framework_Error');

        // erro url
        $args = array($urlStringInvalid, $seoStats);
        $results[]= array($args, null, $exceptionUrl);

        $args = array($urlObjectInvalid, $seoStats);
        $results[]= array($args, null, $exceptionUrl);


        return $results;
    }
}
