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
interface SecureUtilCmnInterface
{
    // OpenSSL
    public static function getOpenSSLEncrypt(String $strText, String $strKey = null) : String;
    public static function getOpenSSLDecrypt(String $strText, String $strKey = null) : String;

    // Laravel Crypt
    public static function getLaravelEncrypt(String $strText) : String;
    public static function getLaravelDecrypt(String $strText) : String;
}
