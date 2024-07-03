<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 日記モデル
 *
 * 日記ロジック処理
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class Diaries extends Model
{
    use HasFactory;

    protected $table = 'diaries';

    /**
     * 新規用バリデーションルール(Validation rules for new)
     *
     * @return array
     */
    public static function validationRulesForInsert()
    {
        return [
            'title' => ['required', 'max:200'],
            'contents' => ['required', 'max:200'],
            'weather_id' => ['required'],
            'images' => ['mimes:jpg,png'],
        ];
    }

    /**
     * 編集用バリデーションルール(Editing Validation Rules)
     *
     * @return array
     */
    public static function validationRulesForUpdate()
    {
        return [
            'title' => ['required', 'max:200'],
            'contents' => ['required', 'max:200'],
            'weather_id' => ['required'],
            'images' => ['mimes:jpg,png'],
        ];
    }

    /**
     * 新規用バリデーションメッセージ(Validation message for new)
     *
     * @return array
     */
    public static function validationMessageForInsert()
    {
        return [
            'title.required' => '【新規】日記タイトルを入力してください',
            'title.max' => '【新規】日記タイトルは200文字未満で入力してください。',
            'contents.required' => '【新規】内容を入力してください',
            'contents.max' => '【新規】内容は200文字未満で入力してください。',
            'weather_id.required' => '【新規】天気を選択してください',
            'images.mimes' => '【新規】画像ファイルはjpegまたはpng画像のみ対応しております。',
        ];
    }

    /**
     * 編集用バリデーションメッセージ(Validation message for editing)
     *
     * @return array
     */
    public static function validationMessageForUpdate()
    {
        return [
            'title.required' => '【編集】日記タイトルを入力してください',
            'title.max' => '【編集】日記タイトルは200文字未満で入力してください。',
            'contents.required' => '【編集】内容を入力してください',
            'contents.max' => '【編集】内容は200文字未満で入力してください。',
            'weather_id.required' => '【編集】天気を選択してください',
            'images.mimes' => '【編集】画像ファイルはjpegまたはpng画像のみ対応しております。',
        ];
    }
}
