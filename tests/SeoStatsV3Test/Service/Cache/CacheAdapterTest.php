<?php

namespace SeoStatsV3Test\Service\Cache;

use SeoStatsV3Test\AbstractSeoStatsTestCase;

class CacheAdapterTest extends AbstractSeoStatsTestCase
{
    protected $SUT;

    public function setup()
    {
        parent::setup();
    }

    /**
     * @group v3
     * @group service
     * @group service-cache
     * @dataProvider providerTestCacheAdapter
     */
    public function testCacheAdapter ($className, $config, $testData)
    {
        $reflectionClass = new \ReflectionClass($className);

        try {
            if (is_array($config) ) {
                $SUT = $reflectionClass->newInstanceArgs($config);
            } else {
                $SUT = $reflectionClass->newInstance();
            }

            foreach ( $testData as $key=>$value) {
                $this->assertFalse($SUT->has($key));

                if ($config === null) {
                    $this->assertFalse($SUT->set($key, $value));
                    $this->assertFalse($SUT->has($key));
                    $this->assertNull($SUT->get($key));
                } else {
                    $this->assertTrue($SUT->set($key, $value));
                    $this->assertTrue($SUT->has($key));
                    $this->assertEquals($value, $SUT->get($key));
                }
            }

        } catch (\RuntimeException $exception) {
            if ($exception->getMessage() !== 'currently no logic') {
                throw new \RuntimeException ("", 0, $exception);
            }
            $this->markTestIncomplete($className . ' ' . $exception->getMessage());
        }
    }

    public function providerTestCacheAdapter()
    {
        $testData = array(
            'key1'=>'valueXYZ',
            'key2'=>'foobar'
        );

        return array(
            array(
                '\SeoStats\V3\Service\Cache\Disabled',
                null,
                $testData
            ),
            array(
                '\SeoStats\V3\Service\Cache\Local',
                true,
                $testData
            ),
            array(
                '\SeoStats\V3\Service\Cache\Mysql',
                array(),
                $testData
            ),
            array(
                '\SeoStats\V3\Service\Cache\Redis',
                array(),
                $testData
            ),
            array(
                '\SeoStats\V3\Service\Cache\Sqlite',
                array(),
                $testData
            ),
        );
    }
}
