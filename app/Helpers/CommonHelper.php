<?php

namespace App\Helpers;

/**
 * Вспомогательный класс для работы с данными
 *
 * @author Amantay Orynbayev
 */
class CommonHelper
{
    public static function getRateByPercent(float $percent)
    {
        return $percent / 100;
    }

    public static function getRemainderRateByPercent(float $percent)
    {
        return 1 - self::getRateByPercent($percent);
    }

    public static function declination(int $number, string $titles, bool $show_number = true): string
    {
        if( is_string( $titles ) ){
            $titles = preg_split( '/, */', $titles );
        }

        if( empty( $titles[2] ) ){
            $titles[2] = $titles[1];
        }

        $cases = [ 2, 0, 1, 1, 1, 2 ];
        $intnum = abs( (int) strip_tags( $number ) );

        $title_index = ( $intnum % 100 > 4 && $intnum % 100 < 20 )
            ? 2
            : $cases[ min( $intnum % 10, 5 ) ];

        return ( $show_number ? "$number " : '' ) . $titles[ $title_index ];
    }
}
