<?php

namespace SeoStatsV3Test\Service\Google;

abstract class AbstractGoogleApiTestCase extends AbstractGoogleTestCase
{
    protected $mockedConfig;
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->mockedConfig = $this->getMock('\SeoStats\V3\Service\Config');

        $class = $this->sutClass;
        $this->SUT = new $class($this->mockedConfig);
    }
}
