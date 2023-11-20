<?php
namespace App\Enums;

/**
 * Перечисление языков
 *
 * @author Amantay Orynbayev
 */
class UserEnum extends Enum
{
    const STATUS_DEACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVE = 2;
    const STATUS_BLOCKED = 3;

}
