<?php
namespace App\Common\Const;

/**
 * 共通メソッド(Common Methods)
 *
 * 文字列関連の処理
 * String-related processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
abstract class DateConst
{

    // 共通メソッド日時に利用(Used for common method date and time)
    const DU_DATE_STRING = 1;
    const DU_FORMATTED_DATE_STRING = 2;
    const DU_TIME_STRING = 3;
    const DU_DATE_TIME_STRING = 4;
    const DU_DAY_DATE_TIME_STRING = 5;
    const DU_FORMAT1 = 6;
    const DU_FORMAT2 = 7;
    const DU_ATOM_STRING = 8;
    const DU_COOKIE_STRING = 9;
    const DU_ISO_8601_STRING = 10;
    const DU_ISO_8601_ZULU_STRING = 11;
    const DU_RFC_822_STRING = 12;
    const DU_RFC_850_STRING = 13;
    const DU_RFC_1036_STRING = 14;
    const DU_RFC_1123_STRING = 15;
    const DU_RFC_2822_STRING = 16;
    const DU_RFC_3339_STRING = 17;
    const DU_RFC_7231_STRING = 18;
    const DU_RSS_STRING = 19;
    const DU_W3C_STRING = 20;

}
