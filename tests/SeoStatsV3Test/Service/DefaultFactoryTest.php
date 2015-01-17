<?php

namespace SeoStatsV3Test\Service\Cache;

use SeoStatsV3Test\AbstractSeoStatsTestCase;

class DefaultFactoryTest extends AbstractSeoStatsTestCase
{
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->SUT = new \SeoStats\V3\Service\DefaultFactory();
    }

    public function testFoo ()
    {
    }

}
