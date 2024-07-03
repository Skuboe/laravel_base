<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * usersテーブル作成(users table creation)
 *
 * データだけのテーブル
 * ユーザを追加することはできないため、一件データを挿入
 * Data-only table
 * Insert data for one case, as users cannot be added
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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('ユーザテーブル');
            $table->id()->comment('ユーザーID');
            $table->string('nickname', 40)->comment('ニックネーム');
            $table->timestamp('updated_at')->useCurrent()->nullable()->comment('更新日');
            $table->timestamp('created_at')->useCurrent()->nullable()->comment('登録日');
        });

        DB::table('users')->insert([
            'nickname' => '山田君'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
