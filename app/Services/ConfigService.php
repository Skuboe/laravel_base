<?php
namespace App\Services;

use App\Repositories\ConfigRepository;
use Illuminate\Support\Facades\Config;

/**
 * 天気サービス(Config Services)
 *
 * 天気サービス処理
 * config service processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class ConfigService
{
    private $_objConfig;

    /**
     * コンストラクタ(construct)
     */
    public function __construct()
    {
        $this->_objConfig = new ConfigRepository;
    }

    /**
     * 全ての天気情報を取得(Retrieve all weathers information)
     *
     * @return void
     */
    public function setMailConfig()
    {
        $aryConfigList = $this->_objConfig->getAllConfig();

        if(!$aryConfigList->isEmpty()){
            foreach($aryConfigList AS $key => $val){
                Config::set("mail.mailers.smtp{$key}.host", $val->mail_host);
                Config::set("mail.mailers.smtp{$key}.port", $val->mail_port);
                Config::set("mail.mailers.smtp{$key}.encryption", $val->mail_encryption);
                Config::set("mail.mailers.smtp{$key}.username", $val->mail_username);
                Config::set("mail.mailers.smtp{$key}.password", $val->mail_password);
            }

            session()->put('use_smtp', "smtp0");
        }
    }

}
