<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * ログインリポジトリ(Login Repository)
 *
 * ログインデータベース処理
 * Login database processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class LoginRepository implements Interface\LoginRepositoryInterface
{
    private $_objLoginDb;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objLoginDb = DB::table('users');
    }

    /**
     * アカウント情報の取得「get account information」
     *
     * @param array $params ログイン情報「login information」
     * @return void
     */
    public function getUserInformation(array $params)
    {
        $intLoginId = $this->_objLoginDb
            ->select('users.id')
            ->where('users.mail_address', '=', $params["mail_address"])
            ->where('users.password', '=', $params["password"])
            ->get();

        return $intLoginId["id"];
    }

    /**
     * アカウント作成「create account」
     *
     * @param array $params アカウント情報「account information」
     * @return void
     */
    public function insCreateUser(array $params){
        $intLastId = $this->_objLoginDb->insertGetId($params);

        return $intLastId;
    }

}
