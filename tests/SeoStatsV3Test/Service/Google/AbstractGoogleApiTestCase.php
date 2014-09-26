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
}
