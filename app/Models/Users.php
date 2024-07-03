<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ユーザモデル(user model)
 *
 * ユーザービジネスロジック処理
 * user business logic processing
 *
 * @package 簡易日記
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class Users extends Model
{
    use HasFactory;

    protected $table = 'users';

}
