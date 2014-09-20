<?php

namespace SeoStatsV3Test\Service\Google;

use SeoStats\V3\Service\Google;
use SeoStats\V3\Module\Page;

class GoogleApiServiceTest extends AbstractGoogleTestCase
{

    protected $mockedClient = null;
    protected $mockedConfig = null;
    protected $mockedCache = null;

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
    public function testUrlFormatSetterAndGetter ()
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

        $this->mockedCache = $this->getMock('\SeoStats\V3\Service\Cache\AbstractCacheAdapter');
        $this->mockedCache->expects($this->once())
               ->method('has')
               ->will($this->returnValue(false));
        $sut->setCacheAdapter($this->mockedCache);

        $this->mockedClient = $this->getMock('\SeoStats\V3\HttpAdapter\HttpAdapterInterface');
        $this->mockedClient->expects($this->once())
              ->method('has')
              ->will($this->returnValue(false));
        $sut->setHttpAdapter($this->mockedClient);

        $page = new Page('github.com');
        $result = $sut->getSearchResultsTotal($page);
    }


    public function helperCreateSut ()
    {
        $this->mockedConfig = $this->getMock('\SeoStats\V3\Service\Config');
        $this->mockedConfig->expects($this->once())
               ->method('get')
               ->with('google-search-api-url')
               ->will($this->returnValue('test-url'));

        return $this->getMockBuilder('\SeoStats\V3\Service\Google\AbstractGoogleApiService')
                    ->setConstructorArgs(array($this->mockedConfig))
                    ->getMockForAbstractClass();
    }
}
