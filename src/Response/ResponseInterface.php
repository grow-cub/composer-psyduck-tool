<?php

namespace Psyduck\Response;

use Psyduck\Context\ContextInterface;
use Psyduck\DefVariable\DefVariableInterface;
use Psyduck\Hump\HumpInterface;
use Psyduck\Monitor\MonitorInterface;
use Psyduck\Pako\PakoInterface;

class ResponseInterface
{
    /**
     * 成功响应
     * @param ContextInterface $context
     * @param $data
     * @return array|string|void
     */
    public static function success(ContextInterface $context,$data = null)
    {
        return self::response($context,0, "success", $data);
    }

    /**
     * 错误返回
     * @param ContextInterface $context
     * @param $errorMsg
     * @return array|string|void
     */
    public static function error(ContextInterface $context,$errorMsg = null)
    {
        $data = array();
        $data['error_msg'] = $errorMsg;
        return self::response($context,-1,"error",$data);
    }

    /**
     * @param ContextInterface $context
     * @param int $code
     * @param string $msg
     * @param $data
     * @return mixed|void
     */
    public static function response(ContextInterface $context,int $code = 0, string $msg = '', $data = null)
    {
        $obj = [
            'code' => $code,
            'msg' => $msg,
        ];
        if (!is_null($data)) {
            $obj['data'] = $data;
            $obj = self::snakeToHump($obj);
        }
        $obj = self::isCiphertext($obj);
        return self::responseJson($context,$obj);
    }

    /**
     * 是否开启加密返回
     * @param $obj
     * @return mixed|string
     */
    public static function isCiphertext($obj)
    {
        if(DefVariableInterface::$isCiphertext){
            $obj = PakoInterface::encrypt($obj);
        }
        return $obj;
    }

    /**
     * 是否以中间件的形式去加载SnakeToHump true加载 false不加载
     * @param $obj
     * @return array|mixed
     */
    public static function snakeToHump($obj)
    {
        if(!DefVariableInterface::$snakeToHumpMiddleware){
            $obj = HumpInterface::ergodicArraySnakeToHump($obj);
        }
        return $obj;
    }

    /**
     * @param ContextInterface $context
     * @param $obj
     * @return mixed|void
     */
    public static function responseJson(ContextInterface $context,$obj)
    {
        MonitorInterface::onEnd($context);
        if(DefVariableInterface::$deReturnJson){
            echo json_encode($obj);
            exit;
        }
        return $obj;
    }
}
