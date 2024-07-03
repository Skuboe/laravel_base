<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UsersService;
use Illuminate\Support\Facades\Log;

/**
 * ユーザ取得コマンド(User acquisition commands)
 *
 * 登録されているユーザの総数をログ出力する
 * Log out the total number of registered users
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class UserCountCommand extends Command
{

    private $_objUsersSrv;

    /**
     * コンソールコマンドの名前(The name and signature of the console command.)
     *
     * @var string
     */
    protected $signature = 'app:user-count-command';

    /**
     * コンソールコマンドの説明(The console command description.)
     *
     * @var string
     */
    protected $description = 'ユーザー数を取得';

    /**
     * コンストラクタ(construct)
     */
    public function __construct(UsersService $objUsers)
    {
        parent::__construct();

        $this->_objUsersSrv = $objUsers;
    }

    /**
     * コンソールコマンドを実行(Execute the console command.)
     */
    public function handle()
    {

        // 初期化
        // initialization
        $intUserCnt = 0;

        // ユーザ数の取得
        // Obtaining the number of users
        $aryUserCnt = $this->_objUsersSrv->getUserCount();
        foreach($aryUserCnt AS $key => $val){
            $intUserCnt = $val->cnt;
        }

        Log::channel('jplog')->info('登録ユーザー数:', (array)$intUserCnt);
        Log::channel('enlog')->info('Entry user count:', (array)$intUserCnt);

    }
}
