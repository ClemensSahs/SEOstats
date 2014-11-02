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

    private static function guardJsonError($jsonMethode)
    {
        $errorCode = json_last_error();
        if (JSON_ERROR_NONE == $errorCode) {
            return;
        }

        $msg = sprintf('Unable %s content into JSON: %s (code: %s)',
                                            $jsonMethode,
                                            json_last_error_msg(),
                                            $errorCode
                                    );

        throw new \RuntimeException($msg);
    }
}
