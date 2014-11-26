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
     * @expectedException RuntimeException
     * @expectedExceptionMessage SeoStats\V3\Service\Google\BacklinkViaWebmasterTools::call not implementet
     */
    public function testBacklinkViaWebmasterTools ()
    {
        $url = 'www.github.com';
        $page = new Page($url);

        $this->SUT->call($page);
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function testBacklinkViaWebmasterToolsLive ()
    {
        $this->markTestIncomplete("currently we have no code to tests...");
    }
}
