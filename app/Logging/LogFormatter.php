<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Illuminate\Support\Facades\Cookie;

/**
 * ログフォーマットクラス(Log format class)
 *
 * ログ出力のフォーマット変更
 * Change of log output format
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class LogFormatter
{
    private $_strLogFormat = "";

    public function __construct()
    {
        // Configファイルから定数を取得
        // Get constants from Config file
        $strUidKey = config("const.UID_KEY");

        // IPアドレスの取得
        // Obtaining an IP address
        $strRemoteAddr = filter_input(INPUT_SERVER, "REMOTE_ADDR");
        if(empty($strRemoteAddr)){
            $strRemoteAddr = "";
        }

        // COOKIEに保尊しているuidを取得
        // Get uid retained in COOKIE
        $strUid = "";
        if(!empty(Cookie::get($strUidKey))){
            $strUid = Cookie::get($strUidKey);
        }

        // COOKIEに値がなければ、UIDを作成
        // If COOKIE has no value, create UID
        $strUserAgent = filter_input(INPUT_SERVER, "HTTP_USER_AGENT");
        if(empty($strUserAgent)){
            $strUserAgent = "";
        }

        if (empty($strUid)) {
            if(!empty($strRemoteAddr) && !empty($strUserAgent)){
                $strUid = crc32($strRemoteAddr . $strUserAgent . microtime(true));
                Cookie::queue($strUidKey, $strUid, time() + 60 * 60 * 24);
            }
        }

        // ログ出力するカラムを設定
        // Set columns to log output
        $cols = [
            "[%datetime%]",
            "[" . $strRemoteAddr . "]",
            "[" . $strUid . "]",
            "%channel%.%level_name%:",
            "%message%",
            "%context%",
        ];

        // フォーマットを生成
        // Generate format
        $this->_strLogFormat = implode("", $cols) . PHP_EOL;
    }

    /**
     * マジックメソッド(magic method)
     *
     * 動作がオブジェクトに対して行われた場合に、 PHP のデフォルトの動作を上書きする
     * Override PHP default behavior when actions are performed on objects
     *
     * @param \Illuminate\Log\Logger ロガーオブジェクト(Logger object)
     * @return void
     */
    public function __invoke(\Illuminate\Log\Logger $objLogging)
    {
        // 日付のフォーマットを指定
        // Specify date format
        $strDateFormat = "Y/m/d H:i:s";

        // フォーマットを設定
        // Set format
        foreach ($objLogging->getHandlers() as $objHandler) {
            $objHandler->setFormatter(new LineFormatter(
                $this->_strLogFormat, $strDateFormat, 1, 1
            ));
        }
    }
}
