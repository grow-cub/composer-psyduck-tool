<?php

namespace Psyduck\Monitor;

use Psyduck\Ip\IpInterface;
use Psyduck\Str\StrInterface;
use Psyduck\Time\TimeInterface;

class MonitorInterface
{
    public static function onStart($requestData = null){
        $monitor = array();
        // 给请求者分配一个id用来计算时间差
        $monitor['id'] = 1;
        // 毫秒级时间戳
        $monitor['start_time'] = TimeInterface::getMilliSecond();
        // 获取请求方法
        $monitor['requestMethod'] = StrInterface::trimString($_SERVER['REQUEST_METHOD']);
        // 获取control
        $monitor['requestC'] = self::requestRouter()['0'];
        // 获取action
        $monitor['requestA'] = self::requestRouter()['1'];
        // 获取域名后的详细地址
        $monitor['requestUri'] = $_SERVER["REQUEST_URI"];
        // ip
        $monitor['requestIp'] = IpInterface::getClientIp();
        // 请求数据集
        if($requestData){
            $monitor['requestData'] = json_encode($requestData);
        }
        var_dump($monitor);
    }

    /**
     * 请求结束时间
     * @return array
     */
    public static function onEnd(): array
    {
        $monitor = array();
        // 毫秒级时间戳
        $monitor['end_time'] = TimeInterface::getMilliSecond();
        return $monitor;
    }

    /**
     * 获取控制器及
     * @return string[]
     */
    public static function requestRouter(): array
    {
        if (array_key_exists('QUERY_STRING', $_SERVER) && $_SERVER['QUERY_STRING'] !== '/' && strstr($_SERVER['QUERY_STRING'], '&')) {//如果$_SERVER数组中存在'QUERY_STRING'键，那么执行下一步操作。
            $paramsArr = explode('&', $_SERVER['QUERY_STRING']);//获取到?后面的部分后,以&打散成数组
            foreach ($paramsArr as $k => $v) {//遍历这个数组
                $a = explode('=', $v);//以=号打散成数组
                $arr[$a[0]] = $a[1];//获取到控制器+方法
            }
            //array_shift累加的
            $controller = array_shift($arr);//使用array_shift方法获取到控制器.array_shift方法的意思是去掉数组的第一个下标 并把去掉的第一个下标赋值给变量
            $action = array_shift($arr);//使用array_shift方法获取到方法.array_shift方法的意思是去掉数组的第二个下标 并把去掉的第二个下标赋值给变量
        }
        return array(
            'controller' => $controller ?? '',
            'action' => $action ?? ''
        );
    }
}