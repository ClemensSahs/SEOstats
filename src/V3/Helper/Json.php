<?php

namespace SeoStats\V3\Helper;

class Json
{
    const METODE_ENCODE = 'encode';
    const METODE_DECODE = 'decode';

    /**
     *
     * @param string $value
     */
    public static function decode($value, $assoc = false)
    {
        $data = json_decode((string) $value, (bool) $assoc);
        static::guardJsonError(static::METODE_DECODE);

        return $data ?: new \stdClass();
    }

    /**
     *
     * @param string $value
     */
    public static function encode($value)
    {
        $data = json_encode($value);
        static::guardJsonError(static::METODE_ENCODE);

        return $data ?: "{}";
    }

    protected static function guardJsonError($jsonMethode)
    {
        $errorCode = json_last_error();

        if (JSON_ERROR_NONE === $errorCode) {
            return;
        }

        $errorMessage = static::jsonLastErrorMassage($errorCode);

        $msg = sprintf('Unable %s content into JSON: %s . (code: %s)"',
                        $jsonMethode,
                        $errorMessage,
                        $errorCode
                        );

        throw new \RuntimeException($msg);
    }

    protected static function jsonLastErrorMassage()
    {
        if (!static::isNativJsonLastErrorMassageExists()) {
            $errorCode = json_last_error();
            static $errorCodeList = array(
                JSON_ERROR_NONE             => null,
                JSON_ERROR_DEPTH            => 'Maximum stack depth exceeded',
                JSON_ERROR_STATE_MISMATCH   => 'Underflow or the modes mismatch',
                JSON_ERROR_CTRL_CHAR        => 'Unexpected control character found',
                JSON_ERROR_SYNTAX           => 'Syntax error, malformed JSON',
                JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded'
            );

            $message = array_key_exists($errorCode, $errorCodeList)
                ? $errorCodeList[$errorCode]
                : "Unknown error";
        } else {
            $message = json_last_error_msg();
        }

        return $message;
    }

    protected static function isNativJsonLastErrorMassageExists()
    {
        return (bool) function_exists('json_last_error_msg');
    }
}
