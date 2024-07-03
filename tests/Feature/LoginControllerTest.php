<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Logins;

/**
 * ログインコントローラテスト(Login controller test)
 *
 * ログインコントローラのPHPUnit処理
 * Login controller of PHPUnit processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class LoginControllerTest extends TestCase
{
    private $_objUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->_objUser = Logins::factory()->create();
    }

    /**
     * アカウントを作成してログイン処理を実行(Create an account and perform the login process)
     */
    public function TestCreateAcountAndLogin(): void
    {
        // 認証済みユーザーの作成
        // Userモデルからfactory()を呼び出すことでユーザーを作成
        // Create authenticated user
        // Create user by calling factory() from User model
        $this->actingAs($this->_objUser);

        $response = $this->get('/diary');
        $response->assertOk();
    }
}
