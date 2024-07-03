<?php
namespace App\Common;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

/**
 * 共通メソッド(Common Methods)
 *
 * セキュア関連の処理
 * Secure-related processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class SecureUtil implements Interface\SecureUtilCmnInterface
{

    /**
     * 暗号化処理「cryptographic process」
     *
     * @param String $strText 対象文字列「target string」
     * @param String|null $strKey キー「key」
     * @return String 暗号化した文字列「Encrypted string」
     */
    public static function getOpenSSLEncrypt(String $strText, String $strKey = null) : String
    {
        if(is_null($strKey)){
            $strKey = "w38v7qv83v4n7";
        }

        // パティング処理
        // padding process
        if($m = strlen($strText) % 8){
            $strText .= str_repeat("\x00", 8 - $m);
        }

        // OpenSSLによる暗号化
        // Encryption by OpenSSL
        $strEncrypt = openssl_encrypt(
            $strText,
            "aes-256-ecb",
            $strKey,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
        );

        return base64_encode($strEncrypt);
    }

    /**
     * 復号化処理「decoding process」
     *
     * @param String $strText 対象文字列「target string」
     * @param String|null $strKey キー「key」
     * @return String 複合化した文字列「Compounded string」
     */
    public static function getOpenSSLDecrypt(String $strText, String $strKey = null) : String
    {
        if(is_null($strKey)){
            $strKey = "w38v7qv83v4n7";
        }

        // OpenSSLによる復号化
        // Decryption by OpenSSL
        $strDecrypt = trim(
            openssl_decrypt(
                base64_decode($strText),
                "aes-256-ecb",
                $strKey,
                OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
            )
        );

        return $strDecrypt;
    }

    /**
     * 暗号化処理「cryptographic process」
     *
     * @param String $strText 対象文字列「target string」
     * @return String 暗号化した文字列「Encrypted string」
     */
    public static function getLaravelEncrypt(String $strText) : String
    {
        return Crypt::encryptString($strText);
    }

    /**
     * 復号化処理「decoding process」
     *
     * @param String $strText 対象文字列「target string」
     * @return String 複合化した文字列「Compounded string」
     */
    public static function getLaravelDecrypt(String $strText) : String
    {
        return Crypt::decryptString($strText);
    }
}
