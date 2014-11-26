<?php

namespace SeoStatsV3Test\Service\Google;

use SeoStats\V3\Service\Config;

abstract class AbstractGoogleApiTestCase extends AbstractGoogleTestCase
{
    protected $serviceConfig;
    protected $serviceConfigMocked;
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->serviceConfigMocked = $this->getMock('\SeoStats\V3\Service\Config');
        $this->serviceConfig = new Config();

        $class = $this->sutClass;
        $this->SUT = new $class($this->serviceConfig);
    }

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

        $this->mockedHttpAdapter = $httpAdapter;
        $this->mockedResponseObject = $responseObject;

        $this->SUT->setHttpAdapter($this->mockedHttpAdapter);
    }
}
