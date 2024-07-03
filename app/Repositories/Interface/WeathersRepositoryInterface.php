<?php
namespace App\Repositories\Interface;

/**
 * 天気インタフェース(weather interface)
 *
 * 天気定義処理
 * weather (meteorology) processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
interface WeathersRepositoryInterface
{
    public function getAllWeathers();
}
