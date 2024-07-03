<?php
namespace App\Common;

use App\Common\Const\StringConst;
use Illuminate\Support\Facades\Log;

/**
 * 共通メソッド(Common Methods)
 *
 * 文字列関連の処理
 * String-related processing
 *
 * @package 簡易日記(diary)
 * @author kuboe
 * @version 1.0.0
 * @copyright 2023/9
 */
class StringUtil extends StringConst implements Interface\StringUtilCmnInterface
{

    /**
     * 電話番号を何文字で区切るかの最初の数値を取得(Get the first number of how many characters separate phone numbers)
     *
     * @param string $strPhone 電話番号(Phone)
     * @return String
     */
    private static function getFindCode(String $strPhone) : Array|Bool
    {

        $aryFirstPhone[2] = substr($strPhone, 0, 2);
        $aryFirstPhone[3] = substr($strPhone, 0, 3);
        $aryFirstPhone[4] = substr($strPhone, 0, 4);
        $aryFirstPhone[5] = substr($strPhone, 0, 5);
        $aryFirstPhone[6] = substr($strPhone, 0, 6);

        // マッチする桁が多い市外局番を優先
        arsort($aryFirstPhone);

        $aryRetKey = false;
        foreach($aryFirstPhone as $key => $value) {

            if(in_array($value, self::$aryAreaCode) !== false) {
                if ($value === "042" &&
                    (substr($strPhone, 3, 1) === "0" ||
                        substr($strPhone, 3, 2) === "90" ||
                        substr($strPhone, 3, 2) === "92" ||
                        substr($strPhone, 3, 2) === "93" ||
                        substr($strPhone, 3, 2) === "94" ||
                        substr($strPhone, 3, 2) === "95" ||
                        substr($strPhone, 3, 2) === "96" ||
                        substr($strPhone, 3, 2) === "99")) {
                    // 「0420〜」「04290〜」「04292〜」「04293〜」「04294〜」「04295〜」「04296〜」「04299〜」の市外局番は「04」
                    continue;
                }

                $aryRetKey['first'] = $key;

                switch($key) {
                    case '2':
                        $aryRetKey['last'] = 4;
                        break;

                    case '3':
                        $aryRetKey['last'] = 3;
                        break;

                    case '4':
                        $aryRetKey['last'] = 2;
                        break;

                    case '5':
                        $aryRetKey['last'] = 1;
                        break;

                    default:
                        $aryRetKey['last'] = 0;
                        break;

                }
                break;
            }
        }

        return $aryRetKey;
    }

    /**
     * 電話番号にハイフンを追加(Add hyphens to phone numbers)
     *
     * 例 09012345678 → 090-1234-5678
     * Example: 09012345678 → 090-1234-5678
     *
     * @param string $strPhone 電話番号(phone)
     * @return String ハイフンが入った電話番号(Hyphenated phone numbers)
     */
    public static function getHyphonePhoneNumber(String $strPhone) : String
    {

        if (strpos($strPhone, '-') === false) {
            // 携帯電話番号
            // Cell phone number
            if (preg_match('/^(0\d0)/', $strPhone)) {
                return (string) substr($strPhone, 0, 3) . '-' . substr($strPhone, 3, 4) . '-' . substr($strPhone, 7);
            }

            $areaCode = self::getFindCode($strPhone);
            // 固定電話
            // landline phone
            if ((int) $areaCode['first'] === 6) {
                $strPhone = (string) substr($strPhone, 0, $areaCode['first']) . '-' . substr($strPhone, $areaCode['last']);
            } elseif (!empty($areaCode)) {
                $strPhone = (string) substr($strPhone, 0, $areaCode['first']) . '-' . substr($strPhone, $areaCode['first'], $areaCode['last']) . '-' . substr($strPhone, $areaCode['first'] + $areaCode['last']);
            } else {
                $strPhone = (string) substr($strPhone, 0, 4) . '-' . substr($strPhone, 4, 3) . '-' . substr($strPhone, 7, 3);
            }
        }
        return $strPhone;
    }

}
