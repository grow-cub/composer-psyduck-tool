<?php
namespace Psyduck\Hump;

use Closure;
use Throwable;

class ResponseInterface
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws Throwable
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        try {
            $rawData = $response->getContent();
            $jsonData = json_decode($rawData??"[]",true);
            if(isset($jsonData['data']) && is_array($jsonData['data'])){
                //检测输出参数，递归编码hashids
                $jsonData['data'] = HumpInterface::ergodicArraySnakeToHump($jsonData['data']);
                $response->setContent(json_encode($jsonData,JSON_UNESCAPED_UNICODE));
            }
        }catch (Throwable $e){
            throw $e;
        }
        return $response;
    }

    /**
     * 返回接口数据组装
     * @param int $code
     * @param string $msg
     * @param $data
     * @return mixed
     */
    public static function response(int $code, string $msg = '',$data = null){
        $obj = [
            'code' => $code,
            'msg' => $msg,
        ];
        if (!is_null($data)){
            $obj['data'] = $data;
        }
        return response()->json($obj);
    }

    /**
     * 成功返回接口
     * @param $data
     * @return mixed
     */
    public static function success($data = null)
    {
        return self::response(0,"success",$data);
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
}