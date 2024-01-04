<?php

namespace Psyduck\Response;

use Psyduck\Context\ContextInterface;
use Psyduck\Constant\Constant;
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
     * @return void
     */
    public static function response(ContextInterface $context,int $code = 0, string $msg = '', $data = null)
    {
        $obj = [
            'code' => $code,
            'msg' => $msg,
        ];
        if (!is_null($data)) {
            $obj['data'] = $data;
            $obj = HumpInterface::ergodicArraySnakeToHump($obj);
        }
        MonitorInterface::onEnd($context);
        // 是否开启加密返回
        echo Constant::$isCiphertext ? PakoInterface::encrypt($obj) : json_encode($obj);
        exit;
    }
}
