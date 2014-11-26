<?php

namespace SeoStatsV3Test\Service\Google;

use SeoStats\V3\Service\Google;
use SeoStats\V3\Model\Page;
use SeoStats\V3\HttpAdapter\HttpAdapter;

class BacklinksTest extends AbstractGoogleApiTestCase
{
    protected $sutClass = '\SeoStats\V3\Service\Google\Backlinks';

    public function setup()
    {
        parent::setup();
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     */
    public function testBacklinks ()
    {
        $url = 'www.github.com';
        $page = new Page($url);

        $this->helperMockHttpAdapter($url);
        $this->SUT->parseUrl($page);
    }

    /**
     * @group v3
     * @group service
     * @group service-google
     * @group live
     */
    public function testBacklinksLive ()
    {
        $url = 'www.github.com';
        $page = new Page($url);

        $this->SUT->setHttpAdapter(new HttpAdapter());

        $result = $this->SUT->call($page);
        $this->assertGreaterThan(0, $result);
    }
}
