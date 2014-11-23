<?php

namespace SeoStatsV3Test\Service\Google;

use SeoStats\V3\Service\Google;
use SeoStats\V3\Model\Page;
use SeoStats\V3\HttpAdapter\HttpAdapter;

class SiteIndexTotalTest extends AbstractGoogleApiTestCase
{
    protected $sutClass = '\SeoStats\V3\Service\Google\SiteIndexTotal';
    protected $mockedHttpAdapter = null;
    protected $mockedResponseObject = null;

    public function setup()
    {
        parent::setup();
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function testSiteIndexTotal ()
    {
        $url = 'www.github.com';
        $page = new Page($url);

        $this->helperMockHttpAdapter($url);
        $this->SUT->setHttpAdapter($this->mockedHttpAdapter);

        $this->mockedResponseObject->expects($this->once())
                                   ->method('')
                                   ->will();

        $result = $this->SUT->call($page);
        $this->assertGreaterThan(0, $result);
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     * @group live
     */
    public function testSiteIndexTotalLive ()
    {
        $url = 'www.github.com';
        $page = new Page($url);

        $this->SUT->setHttpAdapter(new HttpAdapter());

        $result = $this->SUT->call($page);
        $this->assertGreaterThan(0, $result);
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function helperMockHttpAdapter ($url)
    {
        $httpAdapter = $this->getMock('\SeoStats\V3\HttpAdapter\HttpAdapter');
        $responseObject = $this->getMock('\SeoStats\V3\HttpAdapter\ResponseInterface');

        $httpAdapter->expects($this->once())
                    ->method('setVariable')
                    ->will($this->returnCallback(function($args) use ($url, $httpAdapter)
                    {
                        $this->assertInternalType('array',$args);
                        $this->assertArrayHasKey('google_query', $args);
                        $this->assertArrayHasKey('google_rsz', $args);
                        $this->assertContains($url, $args['google_query']);

                        return $httpAdapter;
                    }));

        $httpAdapter->method('setHttpMethod')->will($this->returnSelf());
        $httpAdapter->method('setUrl')->will($this->returnSelf());
        $httpAdapter->method('send')->will($this->returnValue($responseObject));


       $this->mockedHttpAdapter = $httpAdapter;
       $this->mockedResponseObject = $responseObject;
    }
}
