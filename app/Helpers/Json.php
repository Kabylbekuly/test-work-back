<?php

namespace App\Helpers;

/**
 * Вспомогательный класс для работы с json
 *
 * @author Amantay Orynbayev
 */
class Json
{
    public static function encode($value, $options = 320)
    {
        return json_encode($value, $options);
    }

    public static function htmlEncode($value)
    {
        return static::encode($value, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS);
    }

    public static function isJson($string, &$decode = null)
    {
        $decode = json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function decode(string $json, $asArray = true)
    {
        return json_decode((string) $json, $asArray);
    }
}

