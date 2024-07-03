<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 天気モデル(weather model)
 *
 * 天気ビジネスロジック処理
 * Weather Business Logic Processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class Weathers extends Model
{
    use HasFactory;

    protected $table = 'weathers';
}
