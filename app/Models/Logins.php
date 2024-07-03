<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
/**
 * ログインモデル(login model)
 *
 * ログインビジネスロジック処理
 * login business logic processing
 *
 * @package 簡易日記
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class Logins extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname','mail_address','password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mail_address_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * 新規用バリデーションルール(Validation rules for new)
     *
     * @return array
     */
    public static function validationRulesForLogin()
    {
        return [
            'mail_address' => ['required', 'email'],
            'password' => ['required']
        ];
    }

    /**
     * 編集用バリデーションルール(Editing Validation Rules)
     *
     * @return array
     */
    public static function validationRulesForAccount()
    {
        return [
            'nickname' => ['required'],
            'mail_address' => ['required', 'email'],
            'password' => ['required']
        ];
    }

    /**
     * 新規用バリデーションメッセージ(Validation message for new)
     *
     * @return array
     */
    public static function validationMessageForLogin()
    {
        return [
            'mail_address.required' => 'メールアドレスを入力してください',
            'mail_address.email' => 'メールアドレスの形式が不正です。',
            'password.required' => '【パスワードを入力してください',
        ];
    }

    /**
     * 編集用バリデーションメッセージ(Validation message for editing)
     *
     * @return array
     */
    public static function validationMessageForAccount()
    {
        return [
            'nickname.required' => 'ニックネームを入力してください',
            'mail_address.required' => 'メールアドレスを入力してください',
            'mail_address.email' => 'メールアドレスの形式が不正です。',
            'password.required' => 'パスワードを入力してください',
        ];
    }

}
