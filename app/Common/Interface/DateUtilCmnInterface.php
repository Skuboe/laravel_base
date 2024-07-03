<?php
namespace App\Common\Interface;

/**
 * 各種設定インタフェース(config interface)
 *
 * 各種設定定義処理
 * config (meteorology) processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
interface DateUtilCmnInterface
{
    // チェック(check)
    public static function chkDateTime(String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : bool;
    public static function chkDateTimeFuture(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimePast(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeCurrentYear(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeNextYear(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeLastYear(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeLeapYear(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeCurrentMonth(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeNextMonth(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeLastMonth(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeWeekday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeWeekend(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeMonday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeTuesday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeWednesday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeThursday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeFriday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeSaturday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeSunday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeLastOfMonth(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeToday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeYesterday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeTomorrow(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeNextWeek(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;
    public static function chkDateTimeLastWeek(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool;

    // 日付取得(Date Acquisition)
    public static function getNowDate(String $strTimeZone = "Asia/Tokyo") : String;
    public static function getNowDateByTimeStamp(String $strTimeZone = "Asia/Tokyo") : String;
    public static function getNowDateYear(String $strTimeZone = "Asia/Tokyo") : String;
    public static function getNowDateMonth(String $strTimeZone = "Asia/Tokyo") : String;
    public static function getNowDateDay(String $strTimeZone = "Asia/Tokyo") : String;
    public static function getConvertTimeStampToDateTime(int $intTimeStamp, String $strTimeZone = "Asia/Tokyo") : String;
    public static function getConvertTimeStampUtcToDateTime(int $intTimeStamp, String $strTimeZone = "Asia/Tokyo") : String;
    public static function getJpWeekIso(String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;

    // フォーマット(Format)
    public static function getDateTimeFormat(Int $intFormatType = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;

    // 計算処理(calculation)
    public static function getAddYear(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getAddMonth(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getAddDay(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getAddHour(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getAddMinute(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getAddSecond(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getAddWeek(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getSubYear(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getSubMonth(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getSubDay(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getSubHour(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getSubMinute(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getSubSecond(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;
    public static function getSubWeek(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String;

    // 差分(diff)
    public static function getDiffYear(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int;
    public static function getDiffMonth(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int;
    public static function getDiffDay(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int;
    public static function getDiffHour(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int;
    public static function getDiffMinute(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int;
    public static function getDiffSecond(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int;
    public static function getDiffWeek(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int;
}
