<?php
namespace App\Services;

use App\Repositories\UsersRepository;

/**
 * ユーザサービス(user services)
 *
 * ユーザサービス処理
 * user services processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class UsersService
{
    private $_objUsersRep;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objUsersRep = new UsersRepository;
    }

    public function getUserCount()
    {
        $IntUserCnt = $this->_objUsersRep->getUserCount();

        return $IntUserCnt;
    }

}
