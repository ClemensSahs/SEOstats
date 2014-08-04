<?php

namespace SEOstatsV3Test\Model;

use SeoStats\V3\Model\Url;

class UrlTest extends AbstractModelTestCase
{
    public function setup()
    {
        parent::setup();
    }

    /**
     * @dataProvider providerTestCreateUrl
     * @group v3
     * @group model
     * @group model-url
     */
    public function testCreateUrl ($url, $status)
    {
        if (is_string($status) && class_exists($status)) {
            $this->setExpectedException($status);
        }

        $this->SUT = new Url($url);
        $this->assertEquals($status, $this->SUT->getUrl());
    }

    /**
     * @group v3
     * @group model
     * @group model-url
     */
    public function testGetUrl ()
    {
        $url = 'github.com';

        $this->SUT = new Url($url);
        $this->assertNotEquals($url, $this->SUT->getUrl());
        $this->assertEquals($url, $this->SUT->getUrl(true));
    }

    public function providerTestCreateUrl()
    {
        $result = array();

        $result[] = array('', 'SeoStats\V3\Model\Exception\UrlIsToShortException');
        $result[] = array('.', 'SeoStats\V3\Model\Exception\UrlIsToShortException');
        $result[] = array('//', 'SeoStats\V3\Model\Exception\UrlIsNotValidException');
        $result[] = array('//github.com', 'SeoStats\V3\Model\Exception\UrlIsNotValidException');


        $result[] = array('localhost', 'http://localhost');
        $result[] = array('github.com', 'http://github.com');
        $result[] = array('github.com/path/file?queryKey=queryValue', 'http://github.com/path/file');
        $result[] = array('http://github.com', 'http://github.com');
        $result[] = array('http://github.com/path/file?queryKey=queryValue', 'http://github.com/path/file');
        $result[] = array('https://ssl.github.com', 'http://ssl.github.com');
        $result[] = array('https://ssl.github.com/path/file?queryKey=queryValue', 'http://ssl.github.com/path/file');
        $result[] = array('ftp://github.com', 'http://github.com');
        $result[] = array('ssh://github.com', 'http://github.com');

        return $result;
    }
}
