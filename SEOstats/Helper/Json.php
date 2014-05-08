<?php
namespace SEOstats\Helper;

/**
 * URL-String Helper Class
 *
 * @package    SEOstats
 * @author     Stephan Schmitz <eyecatchup@gmail.com>
 * @copyright  Copyright (c) 2010 - present Stephan Schmitz
 * @license    http://eyecatchup.mit-license.org/  MIT License
 * @updated    2013/02/03
 */
class Json
{
   /**
    * Decodes a JSON string into appropriate variable.
    *
    * @param    string  $str    JSON-formatted string
    * @param    boolean $accos  When true, returned objects will be converted into associative arrays.
    * @return   mixed   number, boolean, string, array, or object corresponding to given JSON input string.
    *                   Note that decode() always returns strings in ASCII or UTF-8 format!
    * @throws \RuntimeException
    */
    public static function decode($str, $assoc = false)
    {
        self::guardJsonAvailable();

        return json_decode($str, (bool) $assoc);
    }

   /**
    * Encodes an arbitrary variable into JSON format.
    *
    * @param    mixed   $var    any number, boolean, string, array, or object to be encoded.
    *                           if var is a string, note that encode() always expects it
    *                           to be in ASCII or UTF-8 format!
    * @return   mixed   JSON string representation of input var or an error if a problem occurs
    * @throws \RuntimeException
    */
    public static function encode($var)
    {
        self::guardJsonAvailable();

        return json_encode($var);
    }

    /**
     * throws an Exception if json extention not available
     *
     * @throws \RuntimeException
     */
    private static function guardJsonAvailable()
    {
        if (! function_exists('json_encode')) {
            throw new \RuntimeException("ext-json is not installed!");
        }
    }
}
