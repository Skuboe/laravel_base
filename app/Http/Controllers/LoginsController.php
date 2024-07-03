<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\LoginService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\Logins;
use App\Plugin\OpenAi\OpenAiGpt;

// use OpenAI;
// use OpenAI\Client;

// use OpenAI\Laravel\Facades\OpenAI;

/**
 * ログインコントローラ(Login Controller)
 *
 * ログイン処理を行う
 * Perform login process
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class LoginsController extends Controller
{
    private $_objLoginSrv;

    /**
     * コンストラクタ(construct)
     *
     * @param DiariesService $diariesService 日記サービス(diary service)
     * @param WeathersService $objWeatherSrv 天気サービス(weather service)
     */
    public function __construct(LoginService $objLogin)
    {
        $this->_objLoginSrv = $objLogin;
    }

    /**
     * ログイン画面「Login screen」
     *
     * @return void
     */
    public function login()
    {
        //dd(\DateUtil::getDiffYear("2018-10-01 23:10:01", ""));
        //dd(\StringUtil::insertHyphonePhoneNumber("0612341234"));

        // $ongGpt = new OpenAiGpt();
        // $ongGpt->execMsgSend("Laravelについて500文字以内にまとめて教えてください");

        // $client = OpenAI::client(env("OPENAI_API_KEY"));
        // $result = $client->chat()->create([
        //     'model' => 'gpt-3.5-turbo',
        //     'messages' => [
        //         ['role' => 'user', 'content' => 'Laravelについて500文字以内にまとめて教えてください'],
        //     ]
        // ]);
        // dd($result);

        // $client = OpenAI::client(env("OPENAI_API_KEY"));
        // $result = $client->completions()->create([
        //     'model' => 'gpt-3.5-turbo',
        //     'prompt' => 'Laravelについて500文字以内にまとめて教えてください',
        // ]);
        // dd($result);

        // $result = OpenAI::chat()->create([
        //     'model' => 'gpt-3.5-turbo',
        //     'messages' => [
        //         ['role' => 'user', 'content' => 'Laravelについて500文字以内にまとめて教えてください'],
        //     ],
        // ]);
        // dd($result);

        return view('login.login');
    }

    /**
     * ログイン処理「login process」
     *
     * @param Request $request
     * @return void
     */
    public function execlogin(LoginRequest $request)
    {

        if (Auth::loginUsingId(1)) {
            $request->session()->regenerate();

            return redirect('diary');
        }

        return back()->withErrors([
            'mail_address'=> 'メールアドレスまたはパスワードが間違っています。'
        ]);
    }

    /**
     * アカウント作成画面「Account creation screen」
     *
     * @return void
     */
    public function account()
    {
        return view('login.account');
    }

    /**
     * アカウント作成処理「account creation process」
     *
     * @param Request $request
     * @return void
     */
    public function regist(LoginRequest $request)
    {

        $params = [
            'nickname'=>$request['nickname'],
            'mail_address'=>$request['mail_address'],
            'password'=>Hash::make($request['password'])
        ];

        $intLastUserId = $this->_objLoginSrv->insCreateUser($params);

        if($intLastUserId !== false){
            Auth::loginUsingId($intLastUserId);
        }

        return redirect('diary');
    }

    /**
     * ログアウト処理「logout process」
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }


}
