<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * configテーブル作成(create config table)
 *
 * データだけのテーブル
 * 各種設定を追加することはできないため、必要な基本データを挿入
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
        Schema::create('config', function (Blueprint $table) {
            $table->comment('各種設定テーブル');
            $table->id()->comment('設定ID');
            $table->string('mail_drive')->length(200)->comment('メールドライバ');
            $table->string('mail_host')->length(200)->comment('メールホスト');
            $table->string('mail_port')->length(200)->comment('メールポート');
            $table->string('mail_username')->length(200)->comment('メールユーザ名');
            $table->string('mail_password')->length(200)->comment('メールパスワード');
            $table->string('mail_encryption')->length(200)->comment('メール暗号形式');
            $table->timestamp('updated_at')->useCurrent()->nullable()->comment('更新日');
            $table->timestamp('created_at')->useCurrent()->nullable()->comment('登録日');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config');
    }
};
