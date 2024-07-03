<?php
namespace App\Plugin\OpenAi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * 共通メソッド(Common Methods)
 *
 * チェック関連の処理
 * Check-related processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class OpenAiGpt
{
    private $_strApiUrlChat;
    private $_strApiUrlEngine;
    private $_strApiKey;
    private $_aryHeader;
    private $_strModel;
    private $_aryMsg;

    public function __construct()
    {
        // GPT API URL
        $this->_strApiUrlChat = "https://api.openai.com/v1/chat/completions";
        $this->_strApiUrlEngine = "https://api.openai.com/v1/engines/%s/completions";

        // GPT API Key
        $this->_strApiKey = env("OPENAI_API_KEY");

        // Header
        $this->_aryHeader = [
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . $this->_strApiKey
        ];

        // Model
        $this->_strModel = "gpt-3.5-turbo";
    }


    public function execPromptSend(String $strMsg)
    {
        $this->_aryMsg = [
            [
                "role" => "user",
                "content" => $strMsg
            ]
        ];

        $aryData = [
            // "model" => "text-davinci-003",
            // "stream" => true,
            //"top_p" => 0.7,
            "max_tokens" => 500,
            "prompt" => $strMsg
        ];

        try{
            $strUrl = str_replace("%s", "text-davinci-003", $this->_strApiUrlEngine);
            $response = Http::withHeaders($this->_aryHeader)->timeout(500)->post($strUrl, $aryData);
            if ($response->json('error')) {
                info('エラーが発生');
            }

            dd($response);
        }catch (\Exception $e) {
            Log::channel('jplog')->critical('[prompt]ChatGPT処理エラー');
            Log::channel('jplog')->info('', (array)$e->getTraceAsString());
            Log::channel('enlog')->critical('[prompt]ChatGPT processing error');
            Log::channel('enlog')->info('', (array)$e->getTraceAsString());
        }
    }

    public function execMsgSend(String $strMsg)
    {

        // system 対話の設定
        // user 質問内容
        // assistant GPTからの返答
        $this->_aryMsg = [
            // [
            //     "role" => "system",
            //     "content" => "あなたは役に立つアシスタントです。",
            // ],
            // [
            //     "role" => "user",
            //     "content" => "2020年のワールドシリーズを制したのは誰か？",
            // ],
            // // [
            // //     "role" => "assistant",
            // //     "content" => "ロサンゼルス・ドジャースがワールドシリーズを制覇しました"
            // // ],
            [
                "role" => "user",
                "content" => $strMsg
            ]
        ];

        $aryData = [
            "model" => $this->_strModel,
            // "stream" => true,
            "top_p" => 0.7,
            "max_tokens" => 500,
            "messages" => $this->_aryMsg
        ];

        try{
            $response = Http::withHeaders($this->_aryHeader)->timeout(500)->post($this->_strApiUrlChat, $aryData);
            if ($response->json('error')) {
                info('エラーが発生');
            }

            dd($response->json());
        }catch (\Exception $e) {
            Log::channel('jplog')->critical('[messages]ChatGPT処理エラー');
            Log::channel('jplog')->info('', (array)$e->getTraceAsString());
            Log::channel('enlog')->critical('[messages]ChatGPT processing error');
            Log::channel('enlog')->info('', (array)$e->getTraceAsString());
        }
    }

}
