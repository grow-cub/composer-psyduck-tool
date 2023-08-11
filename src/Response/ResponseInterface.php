<?php

namespace Psyduck\Response;

use Psyduck\DefConstant\DefConstantInterface;
use Psyduck\Hump\HumpInterface;
use Psyduck\Pako\PakoInterface;

class ResponseInterface
{
    /**
     * @Author 
     * @Description 成功响应
     * @Date 2023/6/7 22:09:35
     * @param $data
     * @return void
     */
    public static function success($data = null)
    {
        return self::response(200, "success", $data);
    }

    /**
     * 错误返回
     * @param $errorMsg
     * @return mixed
     */
    public static function error($errorMsg = null)
    {
        $data = array();
        $data['error_msg'] = $errorMsg;
        return self::response(-1,"error",$data);
    }

    /**
     * @Author 
     * @Description
     * @Date 2023/6/7 22:14:46
     * @param int $code
     * @param string $msg
     * @param $data
     * @return void
     */
    public static function response(int $code = 0, string $msg = '', $data = null)
    {
        $obj = [
            'code' => $code,
            'msg' => $msg,
        ];
        if (!is_null($data)) {
            $obj['data'] = $data;
            // 是否以中间件的形式去加载SnakeToHump true加载 false不加载
            if(!DefConstantInterface::SnakeToHumpMiddleware){
                $obj = HumpInterface::ergodicArraySnakeToHump($obj);
            }
        }
        // 是否开启加密返回
        if(DefConstantInterface::defReturnEncrypt){
            $obj = PakoInterface::encrypt($obj);
        }
        self::frameType($obj);
    }

    /**
     * 判断是什么类型的框架
     * @param $obj
     * @return void
     */
    public static function frameType($obj)
    {
        switch (DefConstantInterface::frameType){
            case 'laravel':
                return $obj;
            break;
            default:
                echo json_encode($obj);
                exit;
            break;
        }
    }
}
