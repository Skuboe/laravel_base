<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiariesService;
use App\Services\WeathersService;
use App\Http\Requests\DiariesRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use App\Mail\SendMail;      //Mailableクラス
use Mail;

/**
 * 日記コントローラ(Diary Controller)
 *
 * 新規・編集・削除・一覧を制御する
 * Control new, edit, delete, and list
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/3
 */
class DiariesController extends Controller
{
    private $_objDiarySrv;
    private $_objWeatherSrv;

    /**
     * コンストラクタ(construct)
     *
     * @param DiariesService $diariesService 日記サービス(diary service)
     * @param WeathersService $objWeather 天気サービス(weather service)
     */
    public function __construct(DiariesService $objDiaries, WeathersService $objWeather)
    {
        $this->_objDiarySrv = $objDiaries;
        $this->_objWeatherSrv = $objWeather;
    }

    /**
     * 日記一覧と登録処理(Diary list and registration process)
     *
     * @return void
     */
    public function index() {

        // 変数初期化
        // variable initialization
        $aryViewData = [];
        $aryDiariesList = [];
        $aryWeathers = [];

        // 日記一覧取得
        // Diary List Acquisition
        $aryDiariesList = $this->_objDiarySrv->getAllDiary();

        // 天気一覧取得
        // Weather list acquisition
        $aryWeathers = $this->_objWeatherSrv->getFetchAll();

        // render情報格納
        // render information storage
        $aryViewData = [
            'diaries_list' => $aryDiariesList,
            'weathers_list' => $aryWeathers,
            'defaultText' => "あいうえお",
            'encryptText' => \SecureUtil::getOpenSSLEncrypt("あいうえお"),
            'decryptText' => \SecureUtil::getOpenSSLdecrypt(\SecureUtil::getOpenSSLEncrypt("あいうえお")),
            'defaultText2' => "あいうえお",
            'encryptText2' => \SecureUtil::getLaravelEncrypt("あいうえお"),
            'decryptText2' => \SecureUtil::getLaraveldecrypt(\SecureUtil::getLaravelEncrypt("あいうえお"))
        ];

        return view('diaries', ['ViewData' => $aryViewData]);
    }

    /**
     * 日記投稿処理(Diary Submission Process)
     *
     * @param DiariesRequest $request リクエスト(request)
     * @return void
     */
    public function create(DiariesRequest $request) {

        // 変数初期化
        // variable initialization
        $strFileName = "";

        // 画像ファイル名の取得
        // Obtaining image file names
        if($request->has('images')){
            $strFileName = $request->file('images')->getClientOriginalName();
        }

        try{
            DB::beginTransaction();

            // INSERT
            $aryParams = [
                "user_id" => Auth::id()
                , "title" => $request->title
                , "contents" => $request->contents
                , "weather_id" => $request->weather_id
                , "file_name" => $strFileName
            ];
            $intLastInsertId = $this->_objDiarySrv->insDiary($aryParams);

            // 画像ファイルの保存
            // Saving image files
            if(!empty($strFileName)){
                // 保持場所(Holding Location)
                //「storage/app/images/diaries_images/{日記ID(diary id)}/{ファイル名(file name)}
                $request->file('images')->storeAS('', "images/diary_images/" . $intLastInsertId . "/" . $strFileName);
            }

            DB::commit();

            // メール送信処理
            // mail service
            $data = [
                "mail_subject" => "日記登録完了",
                "name" => "テスト 太郎",
                "contents" => "日記登録完了"
            ];
            Mail::Mailer(session()->get('use_smtp'))->to('admin@hoge.co.jp')->send(new SendMail($data));

            // ログ出力
            // log output
            Log::channel('jplog')->info('日記新規登録完了', $aryParams);
            Log::channel('enlog')->info('diary creat complete', $aryParams);
        } catch (\Exception $e) {
            DB::rollback();

            // ログ出力
            // log output
            Log::channel('jplog')->critical('日記新規登録失敗');
            Log::channel('jplog')->info('', (array)$e->getTraceAsString());
            Log::channel('enlog')->critical('diary creat fail');
            Log::channel('enlog')->info('', (array)$e->getTraceAsString());
        }

        // 解放
        // liberation
        unset($aryParams);

        return redirect('/diary');
    }

    /**
     * 日記編集処理(Diary Editing Process)
     *
     * @param DiariesRequest $request リクエスト(request)
     * @return void
     */
    public function edit(DiariesRequest $request) {

        // 変数初期化
        // variable initialization
        $strFileName = "";
        $blnDeleteFlg = false;

        // 画像ファイル名の取得
        // Obtaining image file names
        if($request->has('images')){
            $blnDeleteFlg = true;
            $strFileName = $request->file('images')->getClientOriginalName();
        }

        // 変更前の情報を取得
        // Retrieve information before the change
        $aryDiariesId = $this->_objDiarySrv->getDiaryId($request->edit_id);

        try{
            DB::beginTransaction();

            // UPDATE
            $aryParams = [
                "user_id" => Auth::id()
                , "title" => $request->title
                , "contents" => $request->contents
                , "weather_id" => $request->weather_id
                , "file_name" => $strFileName
            ];
            $this->_objDiarySrv->updDiaryId($request->edit_id, $aryParams);

            // 削除処理を実行する場合に、画像が保存されていれば削除する
            // Delete the image if it is saved when executing the deletion process.
            if($blnDeleteFlg && !empty($aryDiariesId[0]->file_name)){
                $oldFilePlaceDir = "/home/laravel/storage/app/images/diary_images/" . $request->delete_id . "/";
                $oldFilePlaceFile = "/home/laravel/storage/app/images/diary_images/" . $request->edit_id . "/" . $aryDiariesId[0]->file_name;
                if(file_exists( $oldFilePlaceFile )){
                    unlink($oldFilePlaceFile);
                    rmdir($oldFilePlaceDir);
                }
            }

            // 画像ファイルの保存
            // Saving image files
            if(!empty($strFileName)){
                $request->file('edit_images')->storeAS("images/diary_images/" . $request->edit_id . "/", $strFileName);
            }
            DB::commit();

            // ログ出力
            // log output
            Log::channel('jplog')->info('日記編集完了', $aryParams);
            Log::channel('enlog')->info('diary eidt complete', $aryParams);
        } catch (\Exception $e) {
            DB::rollback();

            // ログ出力
            // log output
            Log::channel('jplog')->critical('日記編集失敗');
            Log::channel('jplog')->info('', (array)$e->getTraceAsString());
            Log::channel('enlog')->critical('diary edit fail');
            Log::channel('enlog')->info('', (array)$e->getTraceAsString());
        }

        // 解放
        // liberation
        unset($aryParams);

        return $response = response()->json([
            ['success' => true, 'message' => ['成功']],
        ], 200);
    }

    /**
     * 日記削除処理(Diary deletion process)
     *
     * @param Request $request リクエスト(request)
     * @return void
     */
    public function delete(Request $request) {

        // 変更前の情報を取得
        // Retrieve information before the change
        $aryDiaries = $this->_objDiarySrv->getDiaryId($request->delete_id);

        try{
            DB::beginTransaction();

            // DELETE(物理削除)
            // DELETE(Physical Deletion)
            $blnResult = $this->_objDiarySrv->delDiaryId($request->delete_id);

            // 削除処理を実行する場合に、画像が保存されていれば削除する
            // Delete the image if it is saved when executing the deletion process.
            if(!empty($aryDiaries[0]->file_name)){
                $oldFilePlaceDir = "/home/laravel/storage/app/images/diary_images/" . $request->delete_id . "/";
                $oldFilePlaceFile = "/home/laravel/storage/app/images/diary_images/" . $request->delete_id . "/" . $aryDiaries[0]->file_name;
                if(file_exists( $oldFilePlaceFile )){
                    unlink($oldFilePlaceFile);
                    rmdir($oldFilePlaceDir);
                }
            }
            DB::commit();

            // ログ出力
            // log output
            Log::channel('jplog')->info('日記削除完了', [$request->delete_id]);
            Log::channel('enlog')->info('diary delete complete', [$request->delete_id]);
        } catch (\Exception $e) {
            DB::rollback();

            // ログ出力
            // log output
            Log::channel('jplog')->critical('日記削除完了');
            Log::channel('jplog')->info('', (array)$e->getTraceAsString());
            Log::channel('enlog')->critical('diary delete fail');
            Log::channel('enlog')->info('', (array)$e->getTraceAsString());
        }

        // 解放
        // liberation
        unset($objDiaries);

        return redirect('/diary');
    }

}
