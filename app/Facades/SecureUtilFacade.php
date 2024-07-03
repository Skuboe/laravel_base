<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * セキュアファサード(Secure Facade)
 *
 * セキュアファサード処理
 * Secure facade processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class SecureUtilFacade extends Facade
{

    /**
     * インスタンスの依存解決に何を使用するかを定義(Define what to use for instance dependency resolution)
     *
     * @return void
     */
	protected static function getFacadeAccessor()
	{
		return 'SecureUtilFacade';
	}
}
