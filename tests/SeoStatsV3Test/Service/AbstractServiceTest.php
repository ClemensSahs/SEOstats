<?php

namespace SeoStatsV3Test\Service;

use SeoStatsV3Test\AbstractSeoStatsTestCase;

class AbstractServiceTest extends AbstractSeoStatsTestCase
{
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->SUT = new Asset\CustomService();
    }

    /**
     *
     * @group service-factory
     */
    public function testGetNoData ()
    {
        $result = $this->SUT->getNoData();

        $this->assertEquals('n.a.', $result);
    }
}
