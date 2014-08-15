<?php

namespace SeoStatsV3Test\HttpAdapter;

use SeoStatsV3Test\AbstractSeoStatsTestCase;
use SeoStats\V3\HttpAdapter\HttpAdapter;

class HttpAdapterTest extends AbstractSeoStatsTestCase
{
    protected $SUT;

    public function setup()
    {
        parent::setup();

    }

    /**
     * @dataProvider providerTestCreateAdapter
     * @group v3
     * @group http-adapter
     */
    public function testCreateAdapter ($args, $argsMethod, $assert)
    {
        if ($args[0] && $args[1]) {
            $this->SUT = new HttpAdapter($args[0], $args[1]);
        }
        elseif ($args[0]) {
            $this->SUT = new HttpAdapter($args[0]);
        }
        elseif ($args[1]) {
            $this->SUT = new HttpAdapter(null,$args[1]);
        }
        else {
            $this->SUT = new HttpAdapter();
        }

        if(isset($argsMethod[0])) {
            $this->SUT->setBaseUrl($argsMethod[0]);
        }
        if(isset($argsMethod[1])) {
            $this->SUT->setBaseVariable($argsMethod[1]);
        }

        // var_dump($this->SUT->getBaseUrl());
        $this->assertEquals($assert[0], $this->SUT->getBaseUrl());
        // var_dump($this->SUT->getVariable());

        $result = $this->SUT->getBaseVariable();

        foreach ($assert[1] as $key=>$value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($value, $result[$key]);
        }
    }

    public function providerTestCreateAdapter ()
    {
        $validUrl = 'http://localhost';
        $validConfig = array(
            'var1'=>'foo',
            'var2'=>'bar'
        );

        $validArgsFull = array($validUrl, $validConfig);
        $validArgsUrl = array($validUrl, null);
        $validArgsConfig = array(null, $validConfig);
        $validArgsNull = array(null, null);

        return array(
            array(
                $validArgsFull,
                $validArgsNull,
                $validArgsFull
            ),
            array(
                $validArgsUrl,
                $validArgsConfig,
                $validArgsFull
            ),
            array(
                $validArgsConfig,
                $validArgsUrl,
                $validArgsFull
            ),
            array(
                $validArgsNull,
                $validArgsFull,
                $validArgsFull
            ),
            array(
                $validArgsNull,
                $validArgsNull,
                array(null, array())
            )
        );
    }
}
