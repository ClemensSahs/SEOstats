<?php

namespace SeoStatsV3Test\Service\Google;

use SeoStats\V3\Service\Google;
use SeoStats\V3\Module\Page;

class GoogleApiServiceTest extends AbstractGoogleTestCase
{

    public function setup()
    {
        parent::setup();
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function testConstuctServiceFail ()
    {
        try {
            $sut = $this->getMockBuilder('\SeoStats\V3\Service\Google\AbstractGoogleApiService')
                        ->setConstructorArgs(array())
                        ->getMockForAbstractClass();

            $sut;

        } catch (\PHPUnit_Framework_Error $e) {
            $this->assertRegExp('/^Argument 1 passed to (\S+) must be an instance of (\S+), none given, called in/', $e->getMessage());
        }
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function testConstuctService ()
    {
        $sut = $this->helperCreateSut();

        $this->assertEquals('test-url', $sut->getUrlFormat());

        $sut->setUrlFormat('foo-url');
        $this->assertEquals('foo-url', $sut->getUrlFormat());
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function testGetSearchResultsTotal ()
    {
        $sut = $this->helperCreateSut();

        $cache = $this->getMock('\SeoStats\V3\Service\Cache\AbstractCacheAdapter');
        $cache->expects($this->once())
               ->method('has')
               ->will($this->returnValue(false));
        $sut->setCacheAdapter($cache);

        $client = $this->getMock('\SeoStats\V3\HttpAdapter\HttpAdapterInterface');
        $client->expects($this->once())
              ->method('has')
              ->will($this->returnValue(false));

        $page = new Page('github.com');
        $result = $sut->getSearchResultsTotal($page);



    }


    public function helperCreateSut ()
    {
        $config = $this->getMock('\SeoStats\V3\Service\Config');
        $config->expects($this->once())
               ->method('get')
               ->with('google-search-api-url')
               ->will($this->returnValue('test-url'));

        return $this->getMockBuilder('\SeoStats\V3\Service\Google\AbstractGoogleApiService')
                    ->setConstructorArgs(array($config))
                    ->getMockForAbstractClass();
    }
}
