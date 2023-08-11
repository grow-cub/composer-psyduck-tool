<?php

namespace Psyduck\DefConstant;

class DefConstantInterface
{
    // 定义返回前端是否加密 true 加密 false 不加密
    const defReturnEncrypt = true;

    // 是否以中间件的形式去加载SnakeToHump true加载 false不加载
    const SnakeToHumpMiddleware = false;

    // 判断是什么框架，比如tp laravel
    const frameType = 'o';
}