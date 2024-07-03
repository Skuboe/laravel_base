<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * 天気リポジトリ(Weather Repository)
 *
 * 天気データベース処理
 * Weather database processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class WeathersRepository implements Interface\WeathersRepositoryInterface
{
    private $_objWeathersDb;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objWeathersDb = DB::table('weathers');
    }

    /**
     * 全ての天気情報を取得(Retrieve all weathers information)
     *
     * @return void
     */
    public function getAllWeathers()
    {
        $aryWeatherList = $this->_objWeathersDb->get();

        return $aryWeatherList;
    }
}
