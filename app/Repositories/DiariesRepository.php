<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * 日記リポジトリ(Diary Repository)
 *
 * 日記データベース処理
 * Diary database processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class DiariesRepository implements Interface\DiariesRepositoryInterface
{
    private $_objDiariesDb;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objDiariesDb = DB::table('diaries');
    }

    /**
     * 全ての日記情報を取得(Retrieve all diary information)
     *
     * @return void
     */
    public function getAllDiary()
    {
        $aryDiaryList = $this->_objDiariesDb
                ->select('diaries.*', 'users.nickname', 'weathers.weather_name')
                ->join('users', 'diaries.user_id', '=', 'users.id')
                ->join('weathers', 'diaries.weather_id', '=', 'weathers.id')
                ->orderBy('id','desc')
                ->paginate(5);

        return $aryDiaryList;
    }

    /**
     * 日記IDで一件取得(Get one by diary ID)
     *
     * @param integer $intId日記ID(diary id)
     * @return void
     */
    public function getDiaryId(int $intId){
        $aryDiaryList = $this->_objDiariesDb
            ->select('diaries.*', 'users.nickname', 'weathers.weather_name')
            ->join('users', 'diaries.user_id', '=', 'users.id')
            ->join('weathers', 'diaries.weather_id', '=', 'weathers.id')
            ->where('diaries.id', '=', $intId)
            ->get();

        return $aryDiaryList;

    }

    /**
     * 日記登録処理(Diary registration process)
     *
     * @param array $aryParams 登録データ(registration data)
     * @return void
     */
    public function insDiary(array $aryParams){
        $intLastInsertId = $this->_objDiariesDb->insertGetId($aryParams);

        return $intLastInsertId;

    }

    /**
     * 日記編集処理(Diary Editing Process)
     *
     * @param integer $intEditId 日記ID(diary id)
     * @param array $aryParams
     * @return void
     */
    public function updDiaryId(int $intEditId, array $aryParams){
        $this->_objDiariesDb->where('diaries.id', '=', $intEditId)->update($aryParams);
    }

    /**
     * 日記削除処理(Diary deletion process)
     *
     * @param integer $intDeleteId 日記ID(diary id)
     * @return void
     */
    public function delDiaryId(int $intDeleteId){
        $this->_objDiariesDb->where('diaries.id',  '=', $intDeleteId)->delete();
    }

}
