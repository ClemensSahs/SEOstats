<?php

namespace SeoStatsV3Test\HttpAdapter;

use SeoStatsV3Test\AbstractSeoStatsTestCase;
use SeoStats\V3\Helper\Json;

class JsonTest extends AbstractSeoStatsTestCase
{
    protected $SUT_LIST = array();

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        $this->SUT_LIST[]= 'SeoStats\V3\Helper\Json';

        if (defined("HHVM_VERSION") || version_compare(phpversion(), "5.5", ">=")) {
            $this->SUT_LIST[]= 'SeoStatsV3Test\Assert\Helper\HelperJsonMockLastErrorMessage';
        }

        parent::__construct($name, $data, $dataName);
    }

    /**
     * @group v3
     * @group helper
     * @group helper-json
     * @dataProvider providerTestDecode
     */
    public function testDecode ($SUT, $args, $expected)
    {
        try {
            $method = array($SUT,'decode');
            $result = call_user_func_array($method, $args);
        } catch (\Exception $exception) {
            if (is_array($expected) && class_exists($expected[0])) {
                $this->assertInstanceOf($expected[0], $exception);
                $this->assertRegExp($expected[1], $exception->getMessage());

                return;
            }

            throw $exception;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * @group v3
     * @group helper
     * @group helper-json
     * @dataProvider providerTestEncode
     */
    public function testEncode ($SUT, $args, $expected)
    {
        $method = array($SUT,'encode');
        $result = call_user_func_array($method, $args);

        $this->assertEquals($expected, $result);
    }

    protected function providerTestEncodeAndDecodeOverwrite ($dataStackSingle)
    {

        $dataStackNew = array();
        foreach ($this->SUT_LIST as $SUT) {
            foreach ($dataStackSingle as $value) {
                $dataStackNew[] = array_merge(array($SUT), $value);
            }
        }

        return $dataStackNew;
    }

    public function providerTestEncode ()
    {
        $validData1Nativ = array(
            'key1' => 'value',
            'key2' => array(
                'value1',
                'value2'
            )
        );
        $validData1Json = '{"key1":"value","key2":["value1","value2"]}';

        $validData2Nativ = (object) array(
            'key1' => 'value',
            'key2' => (object) array(
                'value1',
                'value2'
            )
        );
        $validData2Json = '{"key1":"value","key2":{"0":"value1","1":"value2"}}';

        return $this->providerTestEncodeAndDecodeOverwrite(array(
            array(
                array($validData1Nativ), $validData1Json
            ),
            array(
                array($validData2Nativ), $validData2Json
            ),
        ));
    }

    public function providerTestDecode ()
    {
        $validData1Nativ = array(
            'key1' => 'value',
            'key2' => array(
                'value1',
                'value2'
            )
        );
        $validData1Json = '{"key1":"value","key2":["value1","value2"]}';

        $validData2Nativ = (object) array(
            'key1' => 'value',
            'key2' => (object) array(
                'value1',
                'value2'
            )
        );
        $validData2Json = '{"key1":"value","key2":{"0":"value1","1":"value2"}}';

        $validData3Nativ = (object) array(
            'key1' => 'value',
            'key2' => (object) array(
                'äöü',
                'value2'
            )
        );
        $validData3Json = sprintf('{"key1":"value","key2":{"0":"%s","1":"value2"}}', 'äöü');

        $invalidDataResponse = new \stdClass();

        $invalidDataJson1 = '';

        $invalidDataJson2 = '{"test"}';
        $invalidDataJson2Response = array('RuntimeException',
                                          sprintf('/\(code: %s\)/i', JSON_ERROR_SYNTAX)
                                          );

        // check latin char error
        $invalidDataJson3 = sprintf('{"test":"%s"}', utf8_decode('äöü'));
        $invalidDataJson3Response = array('RuntimeException',
                                          sprintf('/\(code: %s\)/i', JSON_ERROR_UTF8)
                                          );

        return $this->providerTestEncodeAndDecodeOverwrite(array(
            array(
                array($validData1Json, true), $validData1Nativ
            ),
            array(
                array($validData2Json), $validData2Nativ
            ),
            array(
                array($invalidDataJson1), $invalidDataResponse
            ),
            array(
                array($invalidDataJson2), $invalidDataJson2Response
            ),
            array(
                array($invalidDataJson3), $invalidDataJson3Response
            ),
        ));
    }
}
