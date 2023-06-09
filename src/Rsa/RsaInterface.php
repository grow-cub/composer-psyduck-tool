<?php

namespace Psyduck\Rsa;

/**
 * openssl_get_privatekey 或者 openssl_pkey_get_private 校验私钥
    //公钥加密则要用对应私钥解密
    openssl_public_encrypt
    openssl_private_decrypt
    //私钥加密则要用对应公钥解密
    openssl_private_encrypt
    openssl_public_decrypt
 */

class RsaInterface
{
    /**
     * 获取私钥
     * openssl_pkey_get_private 从证书（PEM 格式的私钥）中解析私钥，得到：真实的密钥资源标识符
     * @return bool|resource
     */
    private static function getPrivateKey()
    {
        $abs_path = dirname(__FILE__) . '/pem/rsa_private_key.pem';
        $content = file_get_contents($abs_path);
        return openssl_pkey_get_private($content);
    }

    /**
     * 获取公钥
     * openssl_pkey_get_public 从证书（PEM 格式的公钥）中解析公钥，得到真实的密钥资源标识符
     * @return bool|resource
     */
    private static function getPublicKey()
    {
        $abs_path = dirname(__FILE__) . '/pem/rsa_public_key.pem';
        $content = file_get_contents($abs_path);
        return openssl_pkey_get_public($content);
    }

    /**
     * 私钥加密
     * openssl_private_encrypt() 使用私钥 key 加密数据 data 并且将结果保存至变量 crypted中。
     * 加密后的数据可以通过公钥 openssl_public_decrypt()函数来解密
     * @param string $data
     * @return string
     */
    public static function privateEncrypt(string $data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data,$encrypted,self::getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 公钥解密
     * openssl_public_decrypt() 使用公钥解密数据
     * 因为上面加密的字符串使用了base64进行了编码，所以，咱们这里解密的时候需要先base64解码一下然后再进行私钥解密
     * @param string $encrypted 加密的字符串
     * @return null
     */
    public static function publicDecrypt(string $encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, self::getPublicKey())) ? $decrypted : null;
    }

    /**
     * 公钥加密
     * openssl_public_encrypt() 使用公钥key解密数据 data 并且将结果保存到变量crypted中。
     * 加密的数据可以通过openssl_private_decrypt()函数解密。
     * 加密后的数据因为是个乱码的字符，咱们这边通过base64进行编码一下
     * @param string $data
     * @return null|string
     */
    public static function publicEncrypt(string $data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data,$encrypted,self::getPublicKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 私钥解密
     * openssl_private_decrypt()  使用私钥解密数据
     * 因为上面加密的字符串使用了base64进行了编码，所以，咱们这里解密的时候需要先base64解码一下然后再进行私钥解密
     * @param string $encrypted 加密的字符串
     * @return null
     */
    public static function privateDecrypt(string $encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;
    }
}