<?php

namespace SeoStatsV3Test\Service\Google;

use SeoStats\V3\Service\Google;
use SeoStats\V3\Model\Page;

class BacklinkViaWebmasterToolsTest extends AbstractGoogleApiTestCase
{
    protected $sutClass = '\SeoStats\V3\Service\Google\BacklinkViaWebmasterTools';

    public function setup()
    {
        parent::setup();
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function testBacklinkViaWebmasterTools ()
    {
        $this->markTestIncomplete();
    }
}
