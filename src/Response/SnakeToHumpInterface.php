<?php

namespace Psyduck\Response;

use Closure;
use Psyduck\Hump\HumpInterface;

class SnakeToHumpInterface
{
    /**
     * 以中间件的形式加载处理数据
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Throwable
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
        }catch (\Throwable $e){
            throw $e;
        }
        return $response;
    }
}