<?php

namespace SeoStatsV3Test\Service\Cache;

use SeoStatsV3Test\AbstractSeoStatsTestCase;

class ConfigTest extends AbstractSeoStatsTestCase
{
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->SUT = new \SeoStats\V3\Service\Config();
    }

    /**
     * @group v3
     * @group service
     * @group service-config
     */
    public function testSetterAndGetter ()
    {
        $dataStack = array(
            'key1'=>true,
            'key2'=>false,
            'key3'=>'foobar',
            'key4'=>array('foo','bar'),
        );

        foreach ($dataStack as $key=>$value) {
            $this->assertFalse($this->SUT->has($key));

            $this->SUT->set($key, $value);

            $this->assertTrue($this->SUT->has($key));
            $this->assertEquals($value, $this->SUT->get($key));
        }

        // reset
        foreach ($dataStack as $key=>$value) {
            $this->SUT->set($key, null);
        }

        $this->SUT->setArray($dataStack);
        foreach ($dataStack as $key=>$value) {
            $this->assertTrue($this->SUT->has($key));
            $this->assertEquals($value, $this->SUT->get($key));
        }
    }

}
