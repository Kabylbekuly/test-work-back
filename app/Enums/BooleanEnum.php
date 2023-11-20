<?php

namespace App\Enums;

/**
 * Перечисление логических значений
 *
 * @author Amantay Orynbayev
 */
class BooleanEnum extends Enum
{
    const YES = 'Y';
    const NO = 'N';

    /**
     * @inheritDoc
     */
    public static function labels()
    {
        return [
            self::YES => __('general.Yes'),
            self::NO => __('general.No'),
        ];
    }
}
