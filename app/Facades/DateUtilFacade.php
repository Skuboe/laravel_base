<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 日時ファサード(Date time Facade)
 *
 * 日時ファサード処理
 * Date time facade processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class DateUtilFacade extends Facade
{

    /**
     * インスタンスの依存解決に何を使用するかを定義(Define what to use for instance dependency resolution)
     *
     * @return void
     */
	protected static function getFacadeAccessor()
	{
		return 'DateUtilFacade';
	}
}
