<?php

namespace Psyduck\OrderNo;

class OrderNoInterface
{
    public static function getOrderNo()
    {
        $houseNum = time() - strtotime(date('Y-m-d', time()));
        $time = date('ymd');
        $length = 20;
        $prefixTime = $time . $houseNum;
        $lastLen = $length - strlen($prefixTime);
        $utimestamp = microtime(true);
        $timestamp = floor($utimestamp);
        $milliseconds = round(($utimestamp - $timestamp) * 1000000);
        $orderNo = $prefixTime . $milliseconds;
        if ($lastLen - strlen($milliseconds) > 0) {
            for ($i = 0; $i < ($lastLen - strlen($milliseconds)); $i++) {
                $orderNo .= rand(1, 9);
            }
        }
        return $orderNo;
    }
}
