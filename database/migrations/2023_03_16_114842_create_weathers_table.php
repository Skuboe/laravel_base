<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * weathersテーブル作成(create weathers table)
 *
 * データだけのテーブル
 * 天気の種類を追加することはできないため、必要な基本データを挿入
 * Data-only table
 * Insert basic data needed as weather types cannot be added
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weathers', function (Blueprint $table) {
            $table->comment('天気テーブル');
            $table->id()->comment('天気ID');
            $table->string('weather_name', 40)->comment('天気名');
            $table->timestamp('updated_at')->useCurrent()->nullable()->comment('更新日');
            $table->timestamp('created_at')->useCurrent()->nullable()->comment('登録日');
        });

        DB::table('weathers')->insert([
            'weather_name' => '晴れ'
        ]);

        DB::table('weathers')->insert([
            'weather_name' => '曇り'
        ]);

        DB::table('weathers')->insert([
            'weather_name' => '雨'
        ]);

        DB::table('weathers')->insert([
            'weather_name' => '雪'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weathers');
    }
};
