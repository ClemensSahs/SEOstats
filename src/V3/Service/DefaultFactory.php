<?php

namespace SeoStats\V3\Service;

class DefaultFactory extends AbstractFactory
{

    public function __construct ()
    {
        parent::__construct();

        $this->serviceClassMap = array(
            'google-backlinks' => '\SeoStats\V3\Service\Google\Backlinks',
            'google-siteindextotal' => '\SeoStats\V3\Service\Google\Siteindextotal',
        );
    }
}
