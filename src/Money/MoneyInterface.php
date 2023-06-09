<?php

namespace Psyduck\Money;

class MoneyInterface
{
    /**
     * @Author 可达鸭
     * @Description 元转分
     * @Date 2023/6/9 16:18:24
     * @param $price
     * @return float|int
     */
    public static function rmbToPenny($price)
    {
        return floatval($price) * 100;
    }

    /**
     * @Author 可达鸭
     * @Description 分转元
     * @Date 2023/6/9 16:18:41
     * @param $money
     * @return string
     */
    public static function pennyToRmb($money): string
    {
        return sprintf("%.2f", $money / 100);
    }
}