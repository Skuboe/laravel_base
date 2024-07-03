<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * ユーザリポジトリ
 *
 * ユーザデータベース処理
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3 kuboe
 */
class UsersRepository implements Interface\UsersRepositoryInterface
{
    private $_objUsersDb;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objUsersDb = DB::table('users');
    }

    public function getUserCount()
    {
        $intUserCnt = $this->_objUsersDb
            ->selectRaw('COUNT(*) AS cnt')
            ->get();

        return $intUserCnt;
    }
}
