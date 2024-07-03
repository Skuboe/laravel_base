<?php
namespace App\Services;

use App\Repositories\LoginRepository;

/**
 * ログインサービス(Login Services)
 *
 * ログインサービス処理
 * login service processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class LoginService
{
    private $_objLogin;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objLogin = new LoginRepository;
    }

    /**
     * アカウント作成「create account」
     *
     * @return void
     */
    public function getUserInformation(array $params)
    {
        $aryDiaryList = $this->_objLogin->getUserInformation($params);

        return $aryDiaryList;
    }

    /**
     * アカウント作成「create account」
     *
     * @return void
     */
    public function insCreateUser(array $params)
    {
        $aryDiaryList = $this->_objLogin->insCreateUser($params);

        return $aryDiaryList;
    }


}
