<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 各種設定モデル(config model)
 *
 * 各種設定ビジネスロジック処理
 * Config Business Logic Processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class Config extends Model
{
    use HasFactory;

    protected $table = 'config';
}
