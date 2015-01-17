<?php

namespace SeoStatsV3Test\Service\Asset;

use SeoStats\V3\Service\AbstractFactory;

class CustomFactory extends AbstractFactory
{

    public function __construct ()
    {
        parent::__construct();

        $this->addClassMapArray(array(
            'service-foo'            => '\SeoStatsV3Test\Service\Asset\CustomService',
            'service-can-not-create' => '\SeoStatsV3Test\Service\Asset\ServiceNotExists',
        ));
    }
}
