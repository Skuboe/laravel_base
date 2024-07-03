<?php

namespace App\Logging;

use Monolog\Processor\IntrospectionProcessor;
use Monolog\Logger;

/**
 * ログ処理クラス(Log processing class)
 *
 * ログ出力の処理
 * Processing log output
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class LogProcessor
{
    public function __invoke($logging)
    {
        // プロセッサーを作成
        // Create processor
        $introspectionProcessor = new IntrospectionProcessor(
            \Monolog\Level::Debug,
            [],
            4
        );

        // ログの各ハンドラにプロセッサーを設定する
        // Set processor for each log handler
        foreach ($logging->getHandlers() as $handler) {
            $handler->pushProcessor($introspectionProcessor);
        }
    }
}
