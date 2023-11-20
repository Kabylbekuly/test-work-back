<?php

namespace App\Helpers;

/**
 * Class JsonResponseHelper
 * @author Amantay Orynbayev
 */
class JsonResponseHelper
{
    /**
     * @param array|null $payload
     * @return array
     */
    public static function parse($payload): array
    {
        return [
            $payload['success'] ?? false,
            $payload['data'] ?? [],
        ];
    }

    public static function isSuccess(array $payload): bool
    {
        list($success, ) = self::parse($payload);

        return (bool) $success;
    }

    /**
     * @param array|null $payload
     * @return mixed
     */
    public static function parseData($payload)
    {
        list(, $data) = self::parse($payload);

        return $data;
    }

    /**
     * @param array $payload
     * @param bool $success
     * @return array
     */
    public static function wrap(array $payload, bool $success): array
    {
        return [
            'success' => $success,
            'data' => $payload,
        ];
    }
}
