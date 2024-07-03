<?php
namespace App\Repositories\Interface;

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
interface ConfigRepositoryInterface
{
    public function getAllConfig();
}
