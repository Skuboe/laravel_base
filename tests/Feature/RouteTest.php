<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * ルートテスト(route test)
 *
 * ルートのPHPUnit処理
 * route of PHPUnit processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class RouteTest extends TestCase
{
    /**
     * ルートテスト(route test)
     *
     * @return void
     */
    public function TestRoute(): void
    {

        // ログイン(login)
        $response = $this->get('/');
        $response->assertStatus(200);

        // アカウント登録(account)
        $response = $this->get('/account');
        $response->assertStatus(200);

        // ログアウト(logout)
        $response = $this->get('/logout');
        $response->assertStatus(302);

        // 日記一覧(diary)
        $response = $this->get('/diary');
        $response->assertStatus(302);

        // 日記登録(diary create)
        $response = $this->get('/create');
        $response->assertStatus(302);

        // 日記編集(diary edit)
        $response = $this->get('/edit');
        $response->assertStatus(302);

        // 日記削除(diary delete)
        $response = $this->get('/delete');
        $response->assertStatus(302);

    }
}
