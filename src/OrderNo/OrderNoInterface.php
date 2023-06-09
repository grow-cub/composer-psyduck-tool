<?php

namespace Psyduck\OrderNo;

class OrderNoInterface
{
    /**
     * @Author 可达鸭
     * @Description 生成订单号
     * @Date 2023/6/9 17:44:11
     * @return string
     */
    public static function getOrderNo(): string
    {
        $order_id_main = date('YmdHis') . rand(10000000, 99999999);
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        return $order_id_main . str_pad((100 - $order_id_sum % 100)
                % 100, 2, '0', STR_PAD_LEFT);
    }
}
