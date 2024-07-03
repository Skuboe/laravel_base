<?php
namespace App\Repositories\Interface;

/**
 * ログインインタフェース(login interface)
 *
 * ログイン定義処理
 * login (meteorology) processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
interface LoginRepositoryInterface
{
    public function getUserInformation(array $params);
    public function insCreateUser(array $params);
}
