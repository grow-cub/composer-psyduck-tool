<?php

namespace Psyduck\DefVariable;

class DefVariableInterface
{
    // 定义返回前端是否加密 true 加密 false 不加密
    public static $defReturnEncrypt;

    /**
     * @param bool $string
     * @return void
     */
    public static function defReturnEncrypt(bool $string = true)
    {
        self::$defReturnEncrypt = $string ?? false;
    }


    // 是否以中间件的形式去加载SnakeToHump true加载 false不加载
    public static $snakeToHumpMiddleware;

    /**
     * @param bool $string
     * @return void
     */
    public static function snakeToHumpMiddleware(bool $string = false)
    {
        self::$snakeToHumpMiddleware = $string ?? false;
    }

    // 是否开启默认json返回 false为不需要
    public static $deReturnJson;

    /**
     * @param bool $string
     * @return void
     */
    public static function deReturnJson(bool $string = false)
    {
        self::$deReturnJson = $string ?? false;
    }


}