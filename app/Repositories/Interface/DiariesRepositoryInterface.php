<?php
namespace App\Repositories\Interface;

/**
 * 日記インタフェース(Diary Interface)
 *
 * 日記定義処理
 * diary definition process
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
interface DiariesRepositoryInterface
{
    public function getAllDiary();
    public function getDiaryId(int $intId);
    public function insDiary(array $aryParams);
    public function updDiaryId(int $intEditId, array $aryParams);
    public function delDiaryId(int $intDeleteId);
}
