<?php

namespace SeoStatsV3Test\Service\Cache;

use SeoStatsV3Test\AbstractSeoStatsTestCase;

class CachableServiceTraitTest extends AbstractSeoStatsTestCase
{
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->SUT = $this->getMockForTrait('\SeoStats\V3\Service\CachableServiceTrait');
        $this->mockedCacheAbapter = $this->getMock('\SeoStats\V3\Service\Cache\CacheAdapterInterface');
    }

    /**
     * @group v3
     * @group service
     * @group service-cache
     */
    public function testCacheAdapterSetterAndGetter ()
    {
        $result1 = $this->helperMakeAccessable($this->SUT,'getCacheAdapter', array());
        $this->assertInstanceOf('\SeoStats\V3\Service\Cache\CacheAdapterInterface', $result1);

        $this->SUT->setCacheAdapter($this->mockedCacheAbapter);
        $result2 = $this->helperMakeAccessable($this->SUT,'getCacheAdapter', array());
        $this->assertInstanceOf('\SeoStats\V3\Service\Cache\CacheAdapterInterface', $result2);

        $this->assertNotSame($result1, $result2);
    }

    /**
     * @group v3
     * @group service
     * @group service-cache
     */
    public function testHasCacheAdapter ()
    {
        $result1 = $this->helperMakeAccessable($this->SUT,'HasCacheAdapter', array());

        $this->helperMakeAccessable($this->SUT,'getCacheAdapter', array());
        $result2 = $this->helperMakeAccessable($this->SUT,'HasCacheAdapter', array());

        $this->assertFalse($result1);
        $this->assertTrue($result2);
    }

    /**
     * @group v3
     * @group service
     * @group service-cache
     */
    public function testHasCache ()
    {
        $testValue = "value";
        $this->mockedCacheAbapter->expects($this->at(0))
                                 ->method('has')
                                 ->with($this->equalTo('testKey'))
                                 ->will($this->returnValue(false));

        $this->mockedCacheAbapter->expects($this->at(2))
                                 ->method('has')
                                 ->with($this->equalTo('testKey'))
                                 ->will($this->returnValue(true));

        $this->mockedCacheAbapter->expects($this->any())
                                 ->method('set')
                                 ->with($this->equalTo('testKey'),
                                        $this->equalTo($testValue));

        $this->mockedCacheAbapter->expects($this->any())
                                 ->method('get')
                                 ->with($this->equalTo('testKey'))
                                 ->will($this->returnValue($testValue));

        $this->SUT->setCacheAdapter($this->mockedCacheAbapter);

        $result1 = $this->helperMakeAccessable($this->SUT, 'hasCache', array('testKey'));

        $this->helperMakeAccessable($this->SUT, 'setCache', array('testKey', $testValue));
        $result2 = $this->helperMakeAccessable($this->SUT, 'hasCache', array('testKey'));
        $result3 = $this->helperMakeAccessable($this->SUT, 'getCache', array('testKey'));

        $this->assertFalse($result1);
        $this->assertTrue($result2);
        $this->assertEquals($testValue, $result3);
    }
}
