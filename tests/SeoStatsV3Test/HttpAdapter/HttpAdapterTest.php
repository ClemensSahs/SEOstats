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
        $this->SUT= new HttpAdapter();
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

    /**
     * @dataProvider providerTestHttpMethodSetterAndGetter
     * @group v3
     * @group http-adapter
     */
    public function testHttpMethodSetterAndGetter ($method, $assert)
    {
        $isException= is_string($assert) && class_exists($assert);
        if ($isException) {
            $this->setExpectedException('\SeoStats\V3\HttpAdapter\Exception\MethodeIsNotAllowedException');
        }

        if (!is_null($method) || $isException) {
            $this->SUT->setHttpMethod($method);
        }

        $this->assertEquals($assert, $this->SUT->getHttpMethod());
    }

    /**
     * @group v3
     * @group http-adapter
     */
    public function testHeaderSetterAndGetter ()
    {
        $result1 = $this->SUT->getHeader();

        $this->SUT->setHeader(array('foo'=>'bar'));
        $result2 = $this->SUT->getHeader();

        $this->SUT->setHeader(array('foo'=>'baz'));
        $result3 = $this->SUT->getHeader();

        $this->assertEquals(array(),$result1);
        $this->assertNotEquals($result1, $result2);
        $this->assertNotEquals($result1, $result3);
        $this->assertNotEquals($result2, $result3);
    }

    /**
     * @group v3
     * @group http-adapter
     */
    public function testBodySetterAndGetter ()
    {
        $result1 = $this->SUT->getBody();

        $this->SUT->setBody(json_encode(array('foo'=>'bar')));
        $result2 = $this->SUT->getBody();

        $this->SUT->setBody(json_encode(array('foo'=>'baz')));
        $result3 = $this->SUT->getBody();

        $this->assertNull($result1);
        $this->assertNotEquals($result1, $result2);
        $this->assertNotEquals($result1, $result3);
        $this->assertNotEquals($result2, $result3);
    }

    /**
     * @group v3
     * @group http-adapter
     */
    public function testClean ()
    {
        $this->SUT->setUrl('http://github.com');

        $this->assertEquals('http://github.com', $this->SUT->getUrl());
        $this->SUT->clean();

        $this->assertNotEquals('http://github.com', $this->SUT->getUrl());
        $this->assertNull($this->SUT->getUrl());
    }

    /**
     * @group v3
     * @group http-adapter
     */
    public function testAutoClean ()
    {
        // default
        $this->SUT->setUrl('http://github.com');

        $this->assertEquals('http://github.com', $this->SUT->getUrl());
        $this->helperMakeAccessable($this->SUT, 'runAutoClean', array());

        $this->assertNotEquals('http://github.com', $this->SUT->getUrl());
        $this->assertNull($this->SUT->getUrl());


        // disable
        $this->SUT->setAutoClean(false);
        $this->SUT->setUrl('http://github.com');

        $this->assertEquals('http://github.com', $this->SUT->getUrl());
        $this->helperMakeAccessable($this->SUT, 'runAutoClean', array());

        $this->assertEquals('http://github.com', $this->SUT->getUrl());


        // enable
        $this->SUT->setAutoClean(true);
        $this->SUT->setUrl('http://github.com');

        $this->assertEquals('http://github.com', $this->SUT->getUrl());
        $this->helperMakeAccessable($this->SUT, 'runAutoClean', array());

        $this->assertNotEquals('http://github.com', $this->SUT->getUrl());
        $this->assertNull($this->SUT->getUrl());
    }

    /**
     * @group v3
     * @group http-adapter
     */
    public function testClientSetterAndGetter ()
    {
        $client1 = $this->helperMakeAccessable($this->SUT,'getClient',array());
        $client2 = $this->helperMakeAccessable($this->SUT,'getClient',array());

        $this->helperMakeAccessable($this->SUT,'setClient',array(new \Guzzle\Http\Client()) );
        $client3 = $this->helperMakeAccessable($this->SUT,'getClient',array());

        $this->assertInstanceOf('\Guzzle\Http\Client', $client1);
        $this->assertSame($client1, $client2);
        $this->assertNotSame($client1, $client3);
    }

    /**
     * @dataProvider providerTestSend
     * @group v3
     * @group http-adapter
     */
    public function testSend ($attributes, $assert)
    {
        if ($assert['status'] !== true && class_exists($assert['status'])) {
            $this->setExpectedException($assert['status']);
        }

        $mockedClient = $this->getMock('\Guzzle\Http\Client', array('createRequest'));
        $this->mockedRequest = $this->getMock('\Guzzle\Http\Message\RequestInterface');
        $this->mockedResponse = $this->getMock('\Guzzle\Http\Message\MessageInterface');
        $this->assert = $assert;

        $mockedClient->expects($this->any())
                     ->method('createRequest')
                     ->will($this->returnCallback(array($this,'assertTestSendCallback')));

        $this->mockedRequest->expects($this->any())
                            ->method('send')
                            ->will($this->returnValue($this->mockedResponse));

        $this->helperMakeAccessable($this->SUT, 'setClient', array($mockedClient));

        $this->helperSetAttributes($this->SUT, $attributes);

        $result = $this->SUT->send();

        if ($assert['status'] === true) {
            $this->assertInstanceOf('\SeoStats\V3\HttpAdapter\ResponseInterface', $result);
            $this->assertInstanceOf('\Guzzle\Http\Message\MessageInterface', $result->getResponseObject());
        }
    }

    public function assertTestSendCallback ()
    {
        if (isset($this->assert['httpMethode'])) {
            $this->assertEquals($this->assert['httpMethode'], func_get_arg(0));
        }

        if (isset($this->assert['httpUrl'])) {
            $this->assertEquals($this->assert['httpUrl'], func_get_arg(1));
        }

        if (isset($this->assert['httpHeader'])) {
            $this->assertEquals($this->assert['httpHeader'], func_get_arg(2));
        }

        if (isset($this->assert['httpBody'])) {
            $this->assertEquals($this->assert['httpBody'], func_get_arg(3));
        }

        return $this->mockedRequest;
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

    public function providerTestHttpMethodSetterAndGetter ()
    {
        $invalidException = '\SeoStats\V3\HttpAdapter\Exception\MethodeIsNotAllowedException';

        return array(
            array('get', 'get'),
            array('put', 'put'),
            array('delete', 'delete'),
            array('post', 'post'),
            array(null, $invalidException),
            array('null', $invalidException),
            array(null, 'get') // check only getter
        );
    }

    public function providerTestSend ()
    {
        $result = array();

        $result[] = array(
            array(
                'url'         => 'http://www.github.com',
                'variable'    => array('foo'=>'bar'),
            ),
            array(
                'status'      => true,
                'httpMethode' => 'get',
                'httpUrl'     => array('http://www.github.com', array('foo'=>'bar')),
                'httpHeader' => array(),
                'httpBody' => "",
            )
        );

        return $result;
    }
}
