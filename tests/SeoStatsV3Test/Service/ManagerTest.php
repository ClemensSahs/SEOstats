<?php

namespace SeoStatsV3Test\Service;

use SeoStatsV3Test\AbstractSeoStatsTestCase;
use SeoStats\V3\Service\Manager as ServiceManager;

class ManagerTest extends AbstractSeoStatsTestCase
{
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->SUT = new ServiceManager();
    }


    /**
     * @group service-manager
     * @group v3
     */
    public function testSetGetHas ()
    {
        $service = new Asset\CustomService();

        $this->assertFalse($this->SUT->has('foo'));
        $this->SUT->set('foo', $service);

        $this->assertTrue($this->SUT->has('foo'));
        $this->assertSame($service, $this->SUT->get('foo'));
    }

}
