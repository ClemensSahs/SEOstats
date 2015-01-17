<?php

namespace SeoStatsV3Test\Service;

use SeoStatsV3Test\AbstractSeoStatsTestCase;
use SeoStats\V3\Service\Config;
use SeoStats\V3\HttpAdapter\HttpAdapter;

class AbstractFactoryTest extends AbstractSeoStatsTestCase
{
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->SUT = new Asset\CustomFactory();

        $this->SUT->setConfig(new Config());
        $this->SUT->setHttpAdapter(new HttpAdapter());
    }


    /**
    * @group v3
    * @group service-factory
    */
    public function testCreateService ()
    {
        $service = $this->SUT->createService('service-foo');
        $this->assertInstanceOf('SeoStats\V3\Service\AbstractService', $service);
    }


    /**
     * @group v3
     * @group service-factory
     */
    public function testGuardValidService ()
    {
        $service = new Asset\CustomService();
        $this->SUT->guardValidService($service);
    }

    /**
     * @expectedException SeoStats\V3\Service\Exception\CanNotCreateServiceException
     * @group v3
     * @group service-factory
     */
    public function testGuardValidServiceFail ()
    {
        $service = new \StdClass();
        $this->SUT->guardValidService($service);
    }

    /**
     * @group v3
     * @group service-factory
     * @dataProvider providerTestGuardCanCreateService
     */
    public function testGuardCanCreateService ($serviceName, $assert)
    {
        if (is_array($assert)) {
            $this->setExpectedException($assert[0], $assert[1]);
        }

        $result = $this->SUT->guardCanCreateService($serviceName);

        $this->assertNull($result);

    }

    /**
     * @group service-factory
     * @group v3
     */
    public function testInjectConfigIntoService ()
    {
        $service = new Asset\CustomService();

        $config = new Config();
        $this->SUT->setConfig($config);

        $this->SUT->injectConfigIntoService($service);

        $this->assertSame($config, $service->getConfig());
    }

    /**
     * @group service-factory
     * @group v3
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testInjectConfigIntoServiceFail ()
    {
        $service = new \StdClass();
        $this->SUT->injectConfigIntoService($service);
    }

    /**
    * @group service-factory
    * @group v3
    */
    public function testInjectHttpAdapterIntoService ()
    {
        $service = new Asset\CustomService();

        $httpAdapter = new HttpAdapter();
        $this->SUT->setHttpAdapter($httpAdapter);

        $this->SUT->injectHttpAdapterIntoService($service);

        $this->assertSame($httpAdapter, $service->getHttpAdapter());
    }

    /**
    * @group service-factory
    * @group v3
    * @expectedException \PHPUnit_Framework_Error
    */
    public function testInjectHttpAdapterIntoServiceFail ()
    {
        $service = new \StdClass();
        $this->SUT->injectHttpAdapterIntoService($service);
    }

    public function providerTestGuardCanCreateService ()
    {
        $data = array();

        $data[] = array(
            'service-foo',
            true
        );

        $data[] = array(
            'service-is-not-defined',
            array(
                'SeoStats\V3\Service\Exception\CanNotCreateServiceException',
                'Service is not defined'
            )
        );

        $data[] = array(
            'service-can-not-create',
            array(
                'SeoStats\V3\Service\Exception\CanNotCreateServiceException',
                'ServiceClass is not exists or can not loaded'
            )
        );

        return $data;
    }
}
