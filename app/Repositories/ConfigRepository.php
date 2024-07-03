<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * 各種設定リポジトリ(Config Repository)
 *
 * 各種設定データベース処理
 * Config database processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class ConfigRepository implements Interface\ConfigRepositoryInterface
{

    private $_objConfigDb;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objConfigDb = DB::table('config');
    }

    /**
     * 全ての天気情報を取得(Retrieve all weathers information)
     *
     * @return void
     */
    public function getAllConfig()
    {
        $aryConfigList = $this->_objConfigDb->get();

        return $aryConfigList;
    }
}
