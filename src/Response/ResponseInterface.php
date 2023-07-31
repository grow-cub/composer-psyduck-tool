<?php

namespace Psyduck\Response;
use Psyduck\Hump\HumpInterface;
use Psyduck\Pako\PakoInterface;
use Psyduck\DefConstant\DefConstantInterface;

class ResponseInterface
{
    /**
     * @Author 可达鸭
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
     * @Author 可达鸭
     * @Description 失败响应
     * @Date 2023/6/7 22:09:59
     * @param $data
     * @return void
     */
    public static function fail($data = null)
    {
        return self::response(403, "fail", $data);
    }

    /**
     * @Author 可达鸭
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
            $obj = HumpInterface::ergodicArraySnakeToHump($obj);
        }
        if(DefConstantInterface::defReturnEncrypt){
            // 开启加密返回
            echo PakoInterface::encrypt($obj);die;
        }
        // 不开启加密返回
        echo json_encode($obj);die;
    }
}
