<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * diariesテーブル作成(diaries table creation)
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
        Schema::create('diaries', function (Blueprint $table) {
            $table->comment('日記テーブル');
            $table->id()->comment('日記ID');
            $table->integer('user_id')->length(11)->comment('ユーザID');
            $table->string('title')->length(200)->comment('日記タイトル');
            $table->string('contents')->length(200)->comment('日記内容');
            $table->tinyInteger('weather_id')->length(1)->comment('天気ID')->comment('更新日');
            $table->text('file_name')->nullable()->comment('画像ファイル名')->comment('登録日');
            $table->timestamps();
        });

        Schema::table('diaries', function (Blueprint $table) {
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diaries');
    }
};
