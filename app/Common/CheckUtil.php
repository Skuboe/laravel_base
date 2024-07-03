<?php
namespace App\Common;

use Illuminate\Support\Facades\Log;

/**
 * 共通メソッド(Common Methods)
 *
 * チェック関連の処理
 * Check-related processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class checkUtil implements Interface\CheckUtilCmnInterface
{
    /**
     * キャリアメールのチェック(Check your carrier e-mail)
     *
     * @param string $strMailAddress メールアドレス(mailaddress)
     * @return Bool
     */
    public static function chkMobileAddress(String $strMailAddress) : Bool
    {
        return preg_match("/^.+@(docomo\.ne\.jp|au\.com|ezweb\.ne\.jp|softbank\.ne\.jp|i\.softbank\.jp|t\.vodafone\.ne\.jp|d\.vodafone\.ne\.jp|h\.vodafone\.ne\.jp|c\.vodafone\.ne\.jp|k\.vodafone\.ne\.jp|r\.vodafone\.ne\.jp|n\.vodafone\.ne\.jp|s\.vodafone\.ne\.jp|q\.vodafone\.ne\.jp|pdx\.ne\.jp|wm\.pdx\.ne\.jp|di\.pdx\.ne\.jp|dj\.pdx\.ne\.jp|dk\.pdx\.ne\.jp|au\.com|disney\.ne\.jp|wcm\.ne\.jp|willcom\.com|disneymobile\.ne\.jp)$/i", $strMailAddress) ? true : false;
    }

    /**
     * IPアドレス形式チェック
     *
     * OK　255.255.255.255の4つの区切りで0～255の範囲
     * OK 255.255.255.255 range from 0 to 255 with 4 separators
     * NG 数値以外、またはOK条件の範囲外や区切りの数が該当しない[下記のようなもの]
     * NG Non-numeric or out of range of OK conditions or number of delimiters not applicable [see below]
     *  [192.][192.168][192.168.11][192.168.11.300][192..168.11.300][192,168.11.300]
     *
     * @param string $ip_address チェックするIPアドレス(IP address to be checked)
     * @return Bool
     */
    public static function chkIpAddress($strIpAddress) : Bool
    {
        $ip_address_str = '/^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])\.){3}(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])$/';

        if(preg_match($ip_address_str, $strIpAddress)) {
            return true;
        } else {
            return false;
        }
    }



}
