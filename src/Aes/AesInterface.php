<?php

namespace Psyduck\Aes;

/**
 * AES有很多种加密方式如ECB、CBC、CTR、OFB、CFB

    数据块有128位、192位、256位

    填充方式有pkcs5padding、pkcs7padding、zeropadding、iso10126、ansix923、no padding。

    php调用的openssl默认是采用pkcs7padding
 */

class AesInterface{

    private static $cbcIv = '4387438hfdhfdjhg';
    private static  $cbcKey = '235325fdgerteGHdsfsdewred4345341';
    private static $aesCbc = 'AES-256-CBC';

    /**
     * AES-256-CBC 加密
     * @param $data
     * @return string
     */
    public static function encryptCbc($data): string
    {
        $text = openssl_encrypt($data, self::$aesCbc,
            self::$cbcKey, OPENSSL_RAW_DATA, self::$cbcIv);
        return base64_encode($text);
    }

    /**
     * AES-256-CBC 解密
     * @param $text
     * @return string
     */
    public static function decryptCbc($text): string
    {
        $decodeText = base64_decode($text);
        return openssl_decrypt($decodeText, self::$aesCbc,
            self::$cbcKey, OPENSSL_RAW_DATA, self::$cbcIv);
    }

    private static $ecbKey = '235325fdgerteGHdsfsdewred4345341';
    private static $aesEcb = 'AES-256-ECB';

    /**
     * AES-256-ECB 加密
     * @param $data
     * @return string
     */
    public static function encryptEcb($data): string
    {
        $text = openssl_encrypt($data, self::$aesEcb, self::$ecbKey, 1);
        return base64_encode($text);
    }

    /**
     * AES-256-ECB 解密
     * @param $text
     * @return string
     */
    public static function decryptEcb($text): string
    {
        $decodeText = base64_decode($text);
        return openssl_decrypt($decodeText, self::$aesEcb, self::$ecbKey, 1);
    }
}