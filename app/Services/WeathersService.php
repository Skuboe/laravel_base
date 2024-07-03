<?php
namespace App\Services;

use App\Repositories\WeathersRepository;

/**
 * 天気サービス(Weather Services)
 *
 * 天気サービス処理
 * weather service processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class WeathersService
{
    private $_objWeathers;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objWeathers = new WeathersRepository;
    }

    /**
     * 全ての天気情報を取得(Retrieve all weathers information)
     *
     * @return void
     */
    public function getFetchAll()
    {
        $aryWeatherList = $this->_objWeathers->getAllWeathers();

        return $aryWeatherList;
    }

}
