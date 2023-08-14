<?php

namespace Psyduck\Unique;

class UniqueInterface
{
    /**
     * 比较复杂混合型的id
     * 返回结果类似：E2DFFFB3-571E-6CFC-4B5C-9FEDAAF2EFD7
     * @param string $uniqueData
     * @param string $prefix
     * @return string
     */
    public static function hybridId(string $uniqueData = '',string $prefix = 'api'): string
    {
        static $guid = '';
        $data = $uniqueData;
        $uid = uniqid($prefix, true);
        $data .= $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['LOCAL_ADDR'];
        $data .= $_SERVER['LOCAL_PORT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        return substr($hash, 0, 8) .
            '-' .
            substr($hash, 8, 4) .
            '-' .
            substr($hash, 12, 4) .
            '-' .
            substr($hash, 16, 4) .
            '-' .
            substr($hash, 20, 12);
    }

    /**
     * 适用于生成订单id
     * @param string $id
     * @return string
     */
    public static function orderId(string $id = ''): string
    {
        $order_id_main = date('YmdHis') . $id . rand(10000000, 99999999);
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        return $order_id_main . str_pad((100 - $order_id_sum % 100)
                % 100, 2, '0', STR_PAD_LEFT);
    }
}