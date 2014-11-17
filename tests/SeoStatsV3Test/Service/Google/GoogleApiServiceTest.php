<?php

namespace SeoStatsV3Test\Service\Google;

use SeoStats\V3\Service\Google;
use SeoStats\V3\Model\Page;
use SeoStats\V3\SeoStats;


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

            $regExp = $this->isHhvm()
                ? '/^__construct\(\) expects exactly 1 parameter, 0 given/'
                : '/^Argument 1 passed to (\S+) must be an instance of (\S+), none given, called in/';

            $this->assertRegExp($regExp, $e->getMessage());
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
     * @dataProvider providerTestGetSearchResultsTotal
     */
    public function testGetSearchResultsTotal ($response, $expectedResult)
    {
        $sut = $this->helperCreateSut();

        $this->mockedCache = $this->getMock('\SeoStats\V3\Service\Cache\CacheAdapterInterface');
        $this->mockedCache->expects($this->any())
                          ->method('has')
                          ->will($this->returnValue(false));
        $sut->setCacheAdapter($this->mockedCache);

        $this->mockedClient = $this->getMock('\SeoStats\V3\HttpAdapter\HttpAdapter', array('send'));
        $this->mockedClient->expects($this->any())
                           ->method('send')
                           ->will($this->returnValue($response));
        $sut->setHttpAdapter($this->mockedClient);

        $page = new Page('github.com');
        $result1 = $sut->getSearchResultsTotal($page);

        $this->assertEquals($expectedResult, $result1);


        $result2 = $sut->call($page);
        $this->assertEquals($result1, $result2);
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function testGetSearchResultsTotalCache ()
    {
        $sut = $this->helperCreateSut();
        $cachedValue = 'cachedValueString';

        $this->mockedCache = $this->getMock('\SeoStats\V3\Service\Cache\CacheAdapterInterface');
        $this->mockedCache->expects($this->any())
                          ->method('has')
                          ->will($this->returnValue(true));

        $this->mockedCache->expects($this->any())
                          ->method('get')
                          ->will($this->returnValue($cachedValue));

        $sut->setCacheAdapter($this->mockedCache);

        $page = new Page('github.com');
        $result = $sut->getSearchResultsTotal($page);

        $this->assertEquals($cachedValue, $result);
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

    public function providerTestGetSearchResultsTotal()
    {
        $mockedResponse = $this->getMock('\SeoStats\V3\HttpAdapter\ResponseInterface');

        $response = (object) array(
            'responseData' => (object) array (
                'cursor'=> (object) array(
                    'estimatedResultCount'=>'10'
                )
            )
        );
        $validResponse = clone $mockedResponse;
        $validResponse->expects($this->any())
                      ->method('getStatusCode')
                      ->will($this->returnValue(200));
        $validResponse->expects($this->any())
                      ->method('getBody')
                      ->will($this->returnValue(json_encode($response)));
        $validResponse->expects($this->any())
                      ->method('getBodyJson')
                      ->will($this->returnValue($response));

        $response = '';
        $invalidResponse = clone $mockedResponse;
        $invalidResponse->expects($this->any())
                        ->method('getStatusCode')
                        ->will($this->returnValue(200));
        $invalidResponse->expects($this->any())
                        ->method('getBody')
                        ->will($this->returnValue(json_encode($response)));
        $invalidResponse->expects($this->any())
                        ->method('getBodyJson')
                        ->will($this->returnValue($response));


        $response = array();
        $empty1Response = clone $mockedResponse;
        $empty1Response->expects($this->any())
                       ->method('getStatusCode')
                       ->will($this->returnValue(200));
        $empty1Response->expects($this->any())
                       ->method('getBody')
                       ->will($this->returnValue(json_encode($response)));
        $empty1Response->expects($this->any())
                       ->method('getBodyJson')
                       ->will($this->returnValue($response));

        $response = array(
            'responseData' => array (
                'cursor'=>array(
                )
            )
        );
        $empty2Response = clone $mockedResponse;
        $empty2Response->expects($this->any())
                       ->method('getStatusCode')
                       ->will($this->returnValue(200));
        $empty2Response->expects($this->any())
                       ->method('getBody')
                       ->will($this->returnValue(json_encode($response)));
        $empty2Response->expects($this->any())
                       ->method('getBodyJson')
                       ->will($this->returnValue($response));

        $wrongStatusCodeResponse = clone $mockedResponse;
        $wrongStatusCodeResponse->expects($this->any())
                       ->method('getStatusCode')
                       ->will($this->returnValue(500));

        $noData = SeoStats::$NO_DATA;

        return array(
            array($validResponse, '10'),
            array($invalidResponse, $noData),
            array($empty1Response, $noData),
            array($empty2Response, $noData),
            array($wrongStatusCodeResponse, $noData)
        );
    }
}
