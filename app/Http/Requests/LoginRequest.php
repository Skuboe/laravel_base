<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Models\Logins;

/**
 * 日記リクエスト
 *
 * リクエスト制御
 * Request Control
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class LoginRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * ルール処理(rule processing)
     *
     * モデルに登録しているルールを利用する
     * Use rule registered in the model
     *
     * @param Request $request
     * @return array
     */
    public function rules(): array
    {
        if(strpos(url()->current(), 'regist') !== false) {
            return Logins::validationRulesForAccount();
        }

        return Logins::validationRulesForLogin();
    }

    /**
     * メッセージ処理(message handling)
     *
     * モデルに登録しているメッセージを利用する
     * Use messages registered in the model
     *
     * @return throw
     */
    public function messages()
    {
        // 編集時は異なるバリデーションルールを適用する
        // Apply different validation rules when editing
        if(strpos(url()->current(), 'regist') !== false) {
            return Logins::validationMessageForAccount();
        }

        return Logins::validationMessageForLogin();
    }

    /**
     * バリデーションエラー時(On validation error)
     *
     * エラー時登録と編集で処理方法を変更
     * Change processing method by registering and editing in case of error
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {

        $this->merge(['validated' => 'true']);

        if(strpos(url()->current(), 'regist') !== false) {
            throw new HttpResponseException(
                redirect('/account')->withInput($this->input)->withErrors($validator)
            );
        }else{
            throw new HttpResponseException(
                redirect('/')->withInput($this->input)->withErrors($validator)
            );
        }

    }
}
