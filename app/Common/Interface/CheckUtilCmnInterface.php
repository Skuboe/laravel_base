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
interface CheckUtilCmnInterface
{
    public static function chkMobileAddress(String $strMailAddress) : Bool;
    public static function chkIpAddress($strIpAddress) : Bool;
}
