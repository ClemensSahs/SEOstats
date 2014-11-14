<?php

namespace SeoStatsV3Test\HttpAdapter;

use SeoStatsV3Test\AbstractSeoStatsTestCase;
use SeoStatsV3Test\Asset\HttpAdapterAwareTraitObject;

class HttpAdapterAwareTraitTest extends AbstractSeoStatsTestCase
{
    /**
     * @group v3
     * @group http-adapter
     */
    public function testSetterAndGetter ()
    {
        $adapter = $this->getMock('SeoStats\V3\HttpAdapter\HttpAdapterInterface');

        $object = new HttpAdapterAwareTraitObject();

        $object->setHttpAdapter($adapter);
        $this->assertSame($adapter, $object->getHttpAdapter());
    }

    /**
     * @group v3
     * @group http-adapter
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testSetterAndGetterFail ()
    {
        $noAdapter = $this->getMock('SeoStats\V3\HttpAdapter\ResponseInterface');

        $object = new HttpAdapterAwareTraitObject();

        $object->setHttpAdapter($noAdapter);
    }

}
