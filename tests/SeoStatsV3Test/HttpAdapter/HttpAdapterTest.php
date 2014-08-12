<?php

namespace SeoStatsV3Test\HttpAdapter;

use SeoStatsV3Test\AbstractSeoStatsTestCase;

class HttpAdapterTest extends AbstractSeoStatsTestCase
{
    public function setup()
    {
        parent::setup();

    }

    /**
     * @dataProvider providerTestCreateAdapter
     * @group v3
     * @group http-adapter
     */
    public function testCreateAdapter ($args, $assert)
    {
    }

    public function providerTestCreateAdapter ()
    {
        $validUrl = 'http://localhost';
        $validConfig = array(
            'var1'=>'foo',
            'var2'=>'bar'
        );

        return array(
            array(
                array($validUrl, $validConfig),
                array($validUrl, $validConfig)
            )
        );
    }
}
