<?php

namespace Database\Factories;

use App\Models\Logins;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * ログインファクトリ(Login Factory)
 *
 * ログインファクトリデータベース処理
 * Login factory database processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class LoginsFactory extends Factory
{
    // モデルとの紐付け(Ties to model)
    protected $model = Logins::class;

    /**
     * ログインユーザの作成(Create login user)
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'nickname' => $this->faker->name,
            'mail_address' => $this->faker->unique()->safeEmail,
            'mail_address_verified_at' => now(),
            'password' => Hash::make(12345678),
            'remember_token' => Str::random(10),
        ];
    }
}
