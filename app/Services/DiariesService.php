<?php
namespace App\Services;

use App\Repositories\DiariesRepository;

/**
 * 日記サービス(Diary Service)
 *
 * 日記サービス処理(Diary service processing)
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class DiariesService
{
    private $_objDiariesRep;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objDiariesRep = new DiariesRepository;
    }

    /**
     * 全ての日記情報を取得(Retrieve all diary information)
     *
     * @return void
     */
    public function getAllDiary()
    {
        $aryDiaryList = $this->_objDiariesRep->getAllDiary();

        return $aryDiaryList;
    }

    /**
     * 日記IDで一件取得(Get one by diary ID)
     *
     * @param integer $intId 日記ID(diary id)
     * @return void
     */
    public function getDiaryId(int $intId){
        $aryDiaryList = $this->_objDiariesRep->getDiaryId($intId);

        return $aryDiaryList;

    }

    /**
     * 日記登録処理(Diary registration process)
     *
     * @param array $aryParams 登録データ(registration data)
     * @return void
     */
    public function insDiary(array $aryParams){
        $intLastInsertId = $this->_objDiariesRep->insDiary($aryParams);

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
        $aryDiaryList = $this->_objDiariesRep->updDiaryId($intEditId, $aryParams);

        return $aryDiaryList;

    }

    /**
     * 日記削除処理(Diary deletion process)
     *
     * @param integer $intDeleteId 日記ID(diary id)
     * @return void
     */
    public function delDiaryId(int $intDeleteId){
        $blnResult = $this->_objDiariesRep->delDiaryId($intDeleteId);

        return $blnResult;

    }

}
