<?php
namespace App\Common;

use Carbon\Carbon;
use Illuminate\Foundation\Mix;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Object_;
use App\Common\Const\DateConst;

/**
 * 共通メソッド(Common Methods)
 *
 * 日時関連の処理
 * Date time-related processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class DateUtil extends DateConst implements Interface\DateUtilCmnInterface
{
    /**
     * 指定または現在の日時を取得(Get specified or current date and time)
     *
     * 日時の整合チェックも行う
     * Also check for date and time consistency.
     *
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Object|String
     */
    private static function getDateTime(String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : Object|String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        if(!empty($strDateTime)){
            $strDateTimeTemp = $strDateTime;
        }else{
            $strDateTimeTemp = Carbon::now($strTimeZone);
        }

        if(!empty(DateUtil::chkDateTime($strDateTimeTemp, $strTimeZone))){
            if(!empty($strDateTime)){
                $strDateTimeTemp = new Carbon($strDateTime, $strTimeZone);
            }
            return $strDateTimeTemp;
        }

        return "";
    }

    /**
     * 日時の整合性チェック(Date and time consistency check)
     *
     * @param string $strDateTime 日時(data time)
     * @param string $strTimeZone タイムゾーン(timeZone)
     * @return boolean true/false
     */
    public static function chkDateTime(String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : bool
    {
        // 日時の区切りを統一
        // Unified date and time delimitation
        $strDateTemp = str_replace([" ", "/", "-", "年", "月", "日", ":", "時", "分", "秒"], "-", $strDateTime);

        // 日時を配列に分割
        // Split date and time into an array
        $aryDateTemp = explode("-", $strDateTemp);

        $strYear = abs($aryDateTemp[0]);
        $strMonth = abs($aryDateTemp[1]);
        $strDay = abs($aryDateTemp[2]);

        $strHour = isset($aryDateTemp[3]) ? abs($aryDateTemp[3]) : "0";
        $strMinute = isset($aryDateTemp[4]) ? abs($aryDateTemp[4]) : "0";
        $strSecound = isset($aryDateTemp[5]) ? abs($aryDateTemp[5]) : "0";

        try{
            Carbon::createSafe($strYear, $strMonth, $strDay, $strHour, $strMinute, $strSecound, $strTimeZone);

            return true;
        } catch (\Carbon\Exceptions\InvalidDateException $e) {
            Log::channel('jplog')->info('指定した日時は存在しません。 入力値:[' . $strDateTime . ']');
            Log::channel('jplog')->info('', (array)$e->getTraceAsString());
            Log::channel('enlog')->info('The specified date and time do not exist Input:[' . $strDateTime . ']');
            Log::channel('enlog')->info('', (array)$e->getTraceAsString());
        }

        return false;
    }

    /**
     * 現在または指定した日付が未来(Current or specified date in the future)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeFuture(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isFuture()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が過去(Specified date is in the past)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimePast(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isPast()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が今年(Specified date is this year)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeCurrentYear(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isCurrentYear()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が来年(Specified date next year)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeNextYear(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isNextYear()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が去年(The date specified is last year)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeLastYear(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isLastYear()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付がうるう年(Specified date is a leap year)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeLeapYear(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isLeapYear()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が今月(Specified date is this month)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeCurrentMonth(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isCurrentMonth()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が来月(Specified date next month)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeNextMonth(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isNextMonth()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が先月(Specified date is last month)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeLastMonth(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isLastMonth()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が平日[土日以外](The date specified is a weekday [not Saturday or Sunday])
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeWeekday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isWeekday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が週末[土日](The date specified is a weekend [Saturday or Sunday])
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeWeekend(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isWeekend()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が月曜日(Specified date is Monday)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeMonday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isMonday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が火曜日(Specified date is Tuesday)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeTuesday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isTuesday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が水曜日(Specified date is Wednesday)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeWednesday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isWednesday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が木曜日(Specified date is Thursday)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeThursday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isThursday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が金曜日(Specified date is Friday)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeFriday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isFriday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が土曜日(Specified date is Saturday)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeSaturday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isSaturday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が日曜日(Specified date is Sunday)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeSunday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isSunday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が月末(Specified date is the end of the month)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeLastOfMonth(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isLastOfMonth()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が今日(Specified date is today)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeToday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isToday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が昨日(Specified date is yesterday)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeYesterday(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isYesterday()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が明日(Specified date is tomorrow)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeTomorrow(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isTomorrow()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が来週(Specified date is next week)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeNextWeek(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isNextWeek()){
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した日付が先週(Specified date is lastt week)
     *
     * @param string $strDateTime 指定日時(Designated date and time 1)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Bool
     */
    public static function chkDateTimeLastWeek(String $strDateTime, String $strTimeZone = "Asia/Tokyo") : Bool
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        if(!empty($objDateTimeTemp)){
            if($objDateTimeTemp->isLastWeek()){
                return true;
            }
        }

        return false;
    }

    /**
     * 現在の日時を取得(Get current date and time)
     *
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String datetime/empty
     */
    public static function getNowDate(String $strTimeZone = "Asia/Tokyo") : String
    {

        // 日時の整合性チェック
        // Date and time consistency check
        $objDateTimeTemp = Carbon::now($strTimeZone);

        if(!empty(DateUtil::chkDateTime($objDateTimeTemp, $strTimeZone))){
            // 現在の日時を取得
            // Get current date and time
            return $objDateTimeTemp;
        }

        return "";
    }

    /**
     * 現在の日時をTimeStampで取得(Get the current date and time with TimeStamp)
     *
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String datetime/empty
     */
    public static function getNowDateByTimeStamp(String $strTimeZone = "Asia/Tokyo") : String
    {

        // 日時の整合性チェック
        // Date and time consistency check
        $objDateTimeTemp = Carbon::now($strTimeZone);

        if(!empty(DateUtil::chkDateTime($objDateTimeTemp, $strTimeZone))){
            // 現在の日時を取得
            // Get current date and time
            return $objDateTimeTemp->timestamp;
        }

        return "";
    }

    /**
     * 現在の日時から年のみを取得(Get only year from current date and time)
     *
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String datetime/empty
     */
    public static function getNowDateYear(String $strTimeZone = "Asia/Tokyo") : String
    {
        // 日時の整合性チェック
        // Date and time consistency check
        $objDateTimeTemp = Carbon::now($strTimeZone);

        if(!empty(DateUtil::chkDateTime($objDateTimeTemp, $strTimeZone))){
            // 現在の日時から年のみを取得
            // Get only year from current date and time
            return $objDateTimeTemp->year;
        }

        return "";
    }

    /**
     * 現在の日時から月のみを取得(Get only month from current date and time)
     *
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String datetime/empty
     */
    public static function getNowDateMonth(String $strTimeZone = "Asia/Tokyo") : String
    {
        // 日時の整合性チェック
        // Date and time consistency check
        $objDateTimeTemp = Carbon::now($strTimeZone);

        if(!empty(DateUtil::chkDateTime($objDateTimeTemp, $strTimeZone))){
            // 現在の日時から月のみを取得
            // Get only month from current date and time
            return $objDateTimeTemp->month;
        }

        return "";
    }

    /**
     * 現在の日時から日のみを取得(Get only day from current date and time)
     *
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String datetime/empty
     */
    public static function getNowDateDay(String $strTimeZone = "Asia/Tokyo") : String
    {
        // 日時の整合性チェック
        // Date and time consistency check
        $objDateTimeTemp = Carbon::now($strTimeZone);

        if(!empty(DateUtil::chkDateTime($objDateTimeTemp, $strTimeZone))){
            // 現在の日時から日のみを取得
            // Get only day from current date and time
            return $objDateTimeTemp->day;
        }

        return "";
    }

    /**
     * タイムスタンプをDateTimeに変換(Convert timestamp to DateTime)
     *
     * @param integer $intTimeStamp タイムスタンプ(timestamp)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String datetime/empty
     */
    public static function getConvertTimeStampToDateTime(int $intTimeStamp, String $strTimeZone = "Asia/Tokyo") : String
    {

        $strDateTime = "";
        if(!empty($intTimeStamp)){
            $strDateTime = Carbon::createFromTimestamp($intTimeStamp, $strTimeZone);
        }

        if(!empty($strDateTime)){
            return $strDateTime;
        }

        return "";
    }

    /**
     * タイムスタンプUTCをDateTimeに変換(Convert timestamputc to DateTime)
     *
     * @param integer $intTimeStamp タイムスタンプ(timestamp)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String datetime/empty
     */
    public static function getConvertTimeStampUtcToDateTime(int $intTimeStamp, String $strTimeZone = "Asia/Tokyo") : String
    {

        $strDateTime = "";
        if(!empty($intTimeStamp)){
            $strDateTime = Carbon::createFromTimestampUTC($intTimeStamp, $strTimeZone);
        }

        if(!empty($strDateTime)){
            return $strDateTime;
        }

        return "";
    }

    /**
     * 現在または指定の日時から曜日を取得(Get the day of the week from the current or specified date and time)
     *
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String datetime/empty
     */
    public static function getJpWeekIso(String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 取得した数値を元に曜日を設定
        // Set the day of the week based on the values obtained
        $strWeek = "";
        if(!empty($objDateTimeTemp)){
            $intWeek = $objDateTimeTemp->dayOfWeekIso;

            switch((int)$intWeek){
                case 1:
                    $strWeek = "月";
                    break;
                case 2:
                    $strWeek = "火";
                    break;
                case 3:
                    $strWeek = "水";
                    break;
                case 4:
                    $strWeek = "木";
                    break;
                case 5:
                    $strWeek = "金";
                    break;
                case 6:
                    $strWeek = "土";
                    break;
                case 7:
                    $strWeek = "日";
                    break;
                default:
                    break;
            }
        }

        if(!empty($strWeek)){
            return $strWeek;
        }

        return "";
    }

    /**
     * 現在の日付または指定の日時をフォーマット(Format current date or specified date and time)
     *
     * @param integer $intFormatType フォーマットタイプ(format type)
     *      2023-10-01 23:24:00
     *          DU_DATE_STRING:2018-08-07
     *          DU_FORMATTED_DATE_STRING:Aug 7, 2018
     *          DU_TIME_STRING:19:55:33
     *          DU_DATE_TIME_STRING:2018-08-07 19:55:33
     *          DU_DAY_DATE_TIME_STRING:Tue, Aug 7, 2018 7:55 PM
     *          DU_FORMAT1:2018年08月07日 19時55分33秒
     *          DU_FORMAT2:2018/08/07 19:55:33
     *          DU_ATOM_STRING:2018-08-07T19:55:33+09:00
     *          DU_COOKIE_STRING:Tuesday, 07-Aug-2018 19:55:33 JST
     *          DU_ISO_8601_STRING:2018-08-07T19:55:33+09:00
     *          DU_ISO_8601_ZULU_STRING:ISO8601 2018-08-07T10:55:33Z
     *          DU_RFC_822_STRING:Tue, 07 Aug 18 19:55:33 +0900
     *          DU_RFC_850_STRING:Tuesday, 07-Aug-18 19:55:33 JST
     *          DU_RFC_1036_STRING:Tue, 07 Aug 18 19:55:33 +0900
     *          DU_RFC_1123_STRING:Tue, 07 Aug 2018 19:55:33 +0900
     *          DU_RFC_2822_STRING:Tue, 07 Aug 2018 19:55:33 +0900
     *          DU_RFC_3339_STRING:2018-08-07T19:55:33+09:00
     *          DU_RFC_7231_STRING:Tue, 07 Aug 2018 10:55:33 GMT
     *          DU_RSS_STRING:Tue, 07 Aug 2018 19:55:33 +0900
     *          DU_W3C_STRING:2018-08-07T19:55:33+09:00
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getDateTimeFormat(Int $intFormatType = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // TypeによってFormatを指定
        // Specify Format by Type
        $strDateTimeFormat = "";
        if(!empty($objDateTimeTemp)){
            Switch((int)$intFormatType){
                case self::DU_DATE_STRING:
                    // 2018-08-07
                    $strDateTimeFormat = $objDateTimeTemp->toDateString();
                    break;
                case self::DU_FORMATTED_DATE_STRING:
                    // Aug 7, 2018
                    $strDateTimeFormat = $objDateTimeTemp->toFormattedDateString();
                    break;
                case self::DU_TIME_STRING:
                    // 19:55:33
                    $strDateTimeFormat = $objDateTimeTemp->toTimeString();
                    break;
                case self::DU_DATE_TIME_STRING:
                    // 2018-08-07 19:55:33
                    $strDateTimeFormat = $objDateTimeTemp->toDateTimeString();
                    break;
                case self::DU_DAY_DATE_TIME_STRING:
                    // Tue, Aug 7, 2018 7:55 PM
                    $strDateTimeFormat = $objDateTimeTemp->toDayDateTimeString();
                    break;
                case self::DU_FORMAT1:
                    // 2018年08月07日 19時55分33秒
                    $strDateTimeFormat = $objDateTimeTemp->format("Y年m月d日 H時i分s秒");
                    break;
                case self::DU_FORMAT2:
                    // 2018年08月07日 19時55分33秒
                    $strDateTimeFormat = $objDateTimeTemp->format("Y/m/d H:i:s");
                    break;
                case self::DU_ATOM_STRING:
                    // ATOM 2018-08-07T19:55:33+09:00
                    $strDateTimeFormat = $objDateTimeTemp->toAtomString();
                    break;
                case self::DU_COOKIE_STRING:
                    // Cookie Tuesday, 07-Aug-2018 19:55:33 JST
                    $strDateTimeFormat = $objDateTimeTemp->toCookieString();
                    break;
                case self::DU_ISO_8601_STRING:
                    // ISO8601 2018-08-07T19:55:33+09:00
                    $strDateTimeFormat = $objDateTimeTemp->toIso8601String();
                    break;
                case self::DU_ISO_8601_ZULU_STRING:
                    // Zulu（UTC）ISO8601 2018-08-07T10:55:33Z
                    $strDateTimeFormat = $objDateTimeTemp->toIso8601ZuluString();
                    break;
                case self::DU_RFC_822_STRING:
                    // RFC822 Tue, 07 Aug 18 19:55:33 +0900
                    $strDateTimeFormat = $objDateTimeTemp->toRfc822String();
                    break;
                case self::DU_RFC_850_STRING:
                    // RFC850 Tuesday, 07-Aug-18 19:55:33 JST
                    $strDateTimeFormat = $objDateTimeTemp->toRfc850String();
                    break;
                case self::DU_RFC_1036_STRING:
                    // RFC1036 Tue, 07 Aug 18 19:55:33 +0900
                    $strDateTimeFormat = $objDateTimeTemp->toRfc1036String();
                    break;
                case self::DU_RFC_1123_STRING:
                    // RFC1123 Tue, 07 Aug 2018 19:55:33 +0900
                    $strDateTimeFormat = $objDateTimeTemp->toRfc1123String();
                    break;
                case self::DU_RFC_2822_STRING:
                    // RFC2822 Tue, 07 Aug 2018 19:55:33 +0900
                    $strDateTimeFormat = $objDateTimeTemp->toRfc2822String();
                    break;
                case self::DU_RFC_3339_STRING:
                    // RFC3339 2018-08-07T19:55:33+09:00
                    $strDateTimeFormat = $objDateTimeTemp->toRfc3339String();
                    break;
                case self::DU_RFC_7231_STRING:
                    // RFC7231 Tue, 07 Aug 2018 10:55:33 GMT
                    $strDateTimeFormat = $objDateTimeTemp->toRfc7231String();
                    break;
                case self::DU_RSS_STRING:
                    // RSS Tue, 07 Aug 2018 19:55:33 +0900
                    $strDateTimeFormat = $objDateTimeTemp->toRssString();
                    break;
                case self::DU_W3C_STRING:
                    // W3C 2018-08-07T19:55:33+09:00
                    $strDateTimeFormat = $objDateTimeTemp->toW3cString();
                    break;
                default:
                    break;
            }
        }

        return $strDateTimeFormat;
    }

    /**
     * 現在の日付または指定の日時に年を加算(Add year to current date or specified date/time)
     *
     * @param integer $intAddNum 年の加算数値(Additional figures for the year)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getAddYear(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 年に指定の数値を加算
        // Add the specified number to the year
        $strDateTimeYear = "";
        if(!empty($objDateTimeTemp) && (int)$intAddNum >= 1){
            $strDateTimeYear = $objDateTimeTemp->addYears($intAddNum);
        }

        return $strDateTimeYear;
    }

    /**
     * 現在の日付または指定の日時に月を加算(Add month to current date or specified date/time)
     *
     * @param integer $intAddNum 月の加算数値(Additional figures for the month)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getAddMonth(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 月に指定の数値を加算
        // Add the specified number to the month
        $strDateTimeMonth = "";
        if(!empty($objDateTimeTemp) && (int)$intAddNum >= 1){
            $strDateTimeMonth = $objDateTimeTemp->addMonths($intAddNum);
        }

        return $strDateTimeMonth;
    }

    /**
     * 現在の日付または指定の日時に日を加算(Add day to current date or specified date/time)
     *
     * @param integer $intAddNum 日の加算数値(Additional figures for the day)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getAddDay(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 日に指定の数値を加算
        // Add the specified number to the day
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intAddNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->addDays($intAddNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に時間を加算(Add hour to current date or specified date/time)
     *
     * @param integer $intAddNum 時間の加算数値(Additional figures for the hour)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getAddHour(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 時間に指定の数値を加算
        // Add the specified number to the hour
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intAddNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->addHours($intAddNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に分を加算(Add minute to current date or specified date/time)
     *
     * @param integer $intAddNum 分の加算数値(Additional figures for the minute)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getAddMinute(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 分に指定の数値を加算
        // Add the specified number to the minute
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intAddNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->addHours($intAddNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に秒を加算(Add second to current date or specified date/time)
     *
     * @param integer $intAddNum 秒の加算数値(Additional figures for the second)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getAddSecond(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 秒に指定の数値を加算
        // Add the specified number to the second
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intAddNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->addSeconds($intAddNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に週を加算(Add week to current date or specified date/time)
     *
     * @param integer $intAddNum 週の加算数値(Additional figures for the week)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getAddWeek(Int $intAddNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 週に指定の数値を加算
        // Add the specified number to the week
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intAddNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->addWeeks($intAddNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に年を減算(Subtraction year to current date or specified date/time)
     *
     * @param integer $intSubNum 年の減算数値(Subtraction figures for the year)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getSubYear(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 年に指定の数値を減算
        // Sub the specified number to the year
        $strDateTimeYear = "";
        if(!empty($objDateTimeTemp) && (int)$intSubNum >= 1){
            $strDateTimeYear = $objDateTimeTemp->subYears($intSubNum);
        }

        return $strDateTimeYear;
    }

    /**
     * 現在の日付または指定の日時に月を減算(Subtraction month to current date or specified date/time)
     *
     * @param integer $intSubNum 月の減算数値(Subtraction figures for the month)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getSubMonth(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 月に指定の数値を減算
        // Subtraction the specified number to the month
        $strDateTimeMonth = "";
        if(!empty($objDateTimeTemp) && (int)$intSubNum >= 1){
            $strDateTimeMonth = $objDateTimeTemp->subMonths($intSubNum);
        }

        return $strDateTimeMonth;
    }

    /**
     * 現在の日付または指定の日時に日を減算(Subtraction day to current date or specified date/time)
     *
     * @param integer $intSubNum 日の減算数値(Subtraction figures for the day)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getSubDay(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 日に指定の数値を減算
        // Subtraction the specified number to the day
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intSubNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->subDays($intSubNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に時間を減算(Subtraction hour to current date or specified date/time)
     *
     * @param integer $intSubNum 時間の減算数値(Subtraction figures for the hour)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getSubHour(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 時間に指定の数値を減算
        // Subtraction the specified number to the hour
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intSubNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->subHours($intSubNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に分を減算(Subtraction minute to current date or specified date/time)
     *
     * @param integer $intSubNum 分の減算数値(Subtraction figures for the minute)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getSubMinute(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 分に指定の数値を減算
        // Subtraction the specified number to the minute
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intSubNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->subHours($intSubNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に秒を減算(Add second to current date or specified date/time)
     *
     * @param integer $intSubNum 秒の減算数値(Additional figures for the second)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getSubSecond(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 秒に指定の数値を減算
        // Subtraction the specified number to the second
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intSubNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->subSeconds($intSubNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 現在の日付または指定の日時に週を減算(Add week to current date or specified date/time)
     *
     * @param integer $intSubNum 週の減算数値(Additional figures for the week)
     * @param string $strDateTime 指定日時(Designated date and time)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return String
     */
    public static function getSubWeek(Int $intSubNum = 0, String $strDateTime = "", String $strTimeZone = "Asia/Tokyo") : String
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp = self::getDateTime($strDateTime, $strTimeZone);

        // 週に指定の数値を減算
        // Subtraction the specified number to the week
        $strDateTimeDay = "";
        if(!empty($objDateTimeTemp) && (int)$intSubNum >= 1){
            $strDateTimeDay = $objDateTimeTemp->subWeeks($intSubNum);
        }

        return $strDateTimeDay;
    }

    /**
     * 指定した日付の年の差分を取得(Get the difference for a given date year)
     *
     * @param string $strDateTime 指定日時1(Designated date and time 1)
     * @param string $strDateTime 指定日時2(Designated date and time 2)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Int
     */
    public static function getDiffYear(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp1 = self::getDateTime($strDateTime1, $strTimeZone);
        $objDateTimeTemp2 = self::getDateTime($strDateTime2, $strTimeZone);

        // 差分を取得
        // Get the difference
        $intDiffYear = -1;
        if(!empty($objDateTimeTemp1) && !empty($objDateTimeTemp2)){
            $intDiffYear = $objDateTimeTemp1->diffInYears($objDateTimeTemp2);
        }

        return $intDiffYear;
    }

    /**
     * 指定した日付の月の差分を取得(Get the difference for a given date monthy)
     *
     * @param string $strDateTime 指定日時1(Designated date and time 1)
     * @param string $strDateTime 指定日時2(Designated date and time 2)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Int
     */
    public static function getDiffMonth(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp1 = self::getDateTime($strDateTime1, $strTimeZone);
        $objDateTimeTemp2 = self::getDateTime($strDateTime2, $strTimeZone);

        // 差分を取得
        // Get the difference
        $intDiffMonth = -1;
        if(!empty($objDateTimeTemp1) && !empty($objDateTimeTemp2)){
            $intDiffMonth = $objDateTimeTemp1->diffInMonths($objDateTimeTemp2);
        }

        return $intDiffMonth;
    }

    /**
     * 指定した日付の日の差分を取得(Get the difference for a given date Day)
     *
     * @param string $strDateTime 指定日時1(Designated date and time 1)
     * @param string $strDateTime 指定日時2(Designated date and time 2)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Int
     */
    public static function getDiffDay(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp1 = self::getDateTime($strDateTime1, $strTimeZone);
        $objDateTimeTemp2 = self::getDateTime($strDateTime2, $strTimeZone);

        // 差分を取得
        // Get the difference
        $intDiffDay = -1;
        if(!empty($objDateTimeTemp1) && !empty($objDateTimeTemp2)){
            $intDiffDay = $objDateTimeTemp1->diffInDays($objDateTimeTemp2);
        }

        return $intDiffDay;
    }

    /**
     * 指定した日付の時間の差分を取得(Get the difference for a given date Hour)
     *
     * @param string $strDateTime 指定日時1(Designated date and time 1)
     * @param string $strDateTime 指定日時2(Designated date and time 2)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Int
     */
    public static function getDiffHour(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp1 = self::getDateTime($strDateTime1, $strTimeZone);
        $objDateTimeTemp2 = self::getDateTime($strDateTime2, $strTimeZone);

        // 差分を取得
        // Get the difference
        $intDiffHour = -1;
        if(!empty($objDateTimeTemp1) && !empty($objDateTimeTemp2)){
            $intDiffHour = $objDateTimeTemp1->diffInHours($objDateTimeTemp2);
        }

        return $intDiffHour;
    }

    /**
     * 指定した日付の分の差分を取得(Get the difference for a given date Minute)
     *
     * @param string $strDateTime 指定日時1(Designated date and time 1)
     * @param string $strDateTime 指定日時2(Designated date and time 2)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Int
     */
    public static function getDiffMinute(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp1 = self::getDateTime($strDateTime1, $strTimeZone);
        $objDateTimeTemp2 = self::getDateTime($strDateTime2, $strTimeZone);

        // 差分を取得
        // Get the difference
        $intDiffMinute = -1;
        if(!empty($objDateTimeTemp1) && !empty($objDateTimeTemp2)){
            $intDiffMinute = $objDateTimeTemp1->diffInMinutes($objDateTimeTemp2);
        }

        return $intDiffMinute;
    }

    /**
     * 指定した日付の秒の差分を取得(Get the difference for a given date Second)
     *
     * @param string $strDateTime 指定日時1(Designated date and time 1)
     * @param string $strDateTime 指定日時2(Designated date and time 2)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Int
     */
    public static function getDiffSecond(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp1 = self::getDateTime($strDateTime1, $strTimeZone);
        $objDateTimeTemp2 = self::getDateTime($strDateTime2, $strTimeZone);

        // 差分を取得
        // Get the difference
        $intDiffSecond = -1;
        if(!empty($objDateTimeTemp1) && !empty($objDateTimeTemp2)){
            $intDiffSecond = $objDateTimeTemp1->diffInSeconds($objDateTimeTemp2);
        }

        return $intDiffSecond;
    }

    /**
     * 指定した日付の週の差分を取得(Get the difference for a given date Week)
     *
     * @param string $strDateTime 指定日時1(Designated date and time 1)
     * @param string $strDateTime 指定日時2(Designated date and time 2)
     * @param string $strTimeZone タイムゾーン(timezone)
     * @return Int
     */
    public static function getDiffWeek(String $strDateTime1, String $strDateTime2, String $strTimeZone = "Asia/Tokyo") : Int
    {
        // 指定または現在の日時を取得
        // Get specified or current date and time
        $objDateTimeTemp1 = self::getDateTime($strDateTime1, $strTimeZone);
        $objDateTimeTemp2 = self::getDateTime($strDateTime2, $strTimeZone);

        // 差分を取得
        // Get the difference
        $intDiffWeek = -1;
        if(!empty($objDateTimeTemp1) && !empty($objDateTimeTemp2)){
            $intDiffWeek = $objDateTimeTemp1->diffInWeeks($objDateTimeTemp2);
        }

        return $intDiffWeek;
    }

}
