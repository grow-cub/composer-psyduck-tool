<?php

namespace Psyduck\Constant;

class ConstantInterface
{
    // 定义返回前端是否加密 true 加密 false 不加密
    public static $isCiphertext = false;

    //加密mishu key
    public static $mishuKey = 'MISHU_KEY';
    public static $mishuChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    public static $mishuIkey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";

}