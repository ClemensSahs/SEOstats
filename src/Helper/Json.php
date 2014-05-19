<?php

namespace SeoStats\Helper;

class Json
{
    /**
     *
     * @param string $value
     */
    public static function decode($value, $assoc = false)
    {
        $data = json_decode((string) $value, (bool) $assoc);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Unable decode content from JSON: ' . json_last_error());
        }

        return $data ?: new \stdClass();
    }

    /**
     *
     * @param string $value
     */
    public static function encode($value)
    {
        $data = json_encode($value);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Unable encode content into JSON: ' . json_last_error());
        }

        return $data ?: "{}";
    }
}
