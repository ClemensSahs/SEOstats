<?php

namespace SeoStatsV3Test\HttpAdapter;

use SeoStatsV3Test\AbstractSeoStatsTestCase;
use SeoStats\V3\HttpAdapter\Response;

class ResponseTest extends AbstractSeoStatsTestCase
{
    protected $responseObjectMocked;
    protected $SUT;

    public function setup()
    {
        parent::setup();

        $this->responseObjectMocked = $this->getMockBuilder('\GuzzleHttp\Message\ResponseInterface')
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->SUT = new Response($this->responseObjectMocked);
    }

    /**
     * @group v3
     * @group http-adapter
     * @group http-adapter-response
     */
    public function testGetResponseObject ()
    {
        $result = $this->SUT->getResponseObject();
        $this->assertSame($this->responseObjectMocked, $result);
    }

    /**
     * @group v3
     * @group http-adapter
     * @group http-adapter-response
     * @dataProvider providerTestGetStatusCode
     */
    public function testGetStatusCode ($returnDataOrigin)
    {
        $this->responseObjectMocked
             ->expects($this->any())
             ->method('getStatusCode')
             ->will($this->returnValue($returnDataOrigin));

        $result = $this->SUT->getStatusCode();
        $this->assertEquals($returnDataOrigin, $result);
    }

    /**
     * @group v3
     * @group http-adapter
     * @group http-adapter-response
     * @dataProvider providerTestGetBody
     */
    public function testGetBody ($returnDataOrigin)
    {
        $this->responseObjectMocked
             ->expects($this->any())
             ->method('getBody')
             ->will($this->returnValue($returnDataOrigin));

        $result = $this->SUT->getBody();
        $this->assertEquals($returnDataOrigin, $result);
    }

    /**
     * @group v3
     * @group http-adapter
     * @group http-adapter-response
     * @dataProvider providerTestGetBody
     */
    public function testGetBodyJson ($returnDataOrigin, $exceptedJsonDecode)
    {
        $this->responseObjectMocked
             ->expects($this->any())
             ->method('getBody')
             ->will($this->returnValue($returnDataOrigin));

        $result = $this->SUT->getBodyJson();
        $this->assertEquals($exceptedJsonDecode, $result);
    }

    public function providerTestGetBody ()
    {
        $validData = (object) array(
            'key1'=>'value1',
            'key2'=> (object) array(
                'key2.1'=>'value2',
                'key2.2'=>'value3'
            )
        );

        return array(
            array(json_encode($validData), $validData),
            array("", (object) array())
        );
    }

    public function providerTestGetStatusCode ()
    {
        return array(
            array(200),
            array(304),
            array(400),
            array(500)
        );
    }
}
