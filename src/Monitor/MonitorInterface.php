<?php

namespace Psyduck\Monitor;

use Psyduck\Context\ContextInterface;
use Psyduck\Ip\IpInterface;
use Psyduck\Str\StrInterface;
use Psyduck\Time\TimeInterface;
use Psyduck\Unique\UniqueInterface;

class MonitorInterface
{
    public static function onStart($requestData = null): array
    {
        $monitor = array();
        // 给请求者分配一个id用来计算时间差
        $monitor['id'] = UniqueInterface::hybridId();
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
        if($monitor['requestIp']){
            $monitor['requestIp'] = IpInterface::ipInt($monitor['requestIp']);
        }
        // 请求数据集
        if($requestData){
            $monitor['requestData'] = json_encode($requestData);
        }
        return $monitor;
    }

    /**
     * 请求结束时间
     * @param ContextInterface $context
     * @return void
     */
    public static function onEnd(ContextInterface $context)
    {
        // 毫秒级时间戳
        $context->monitor['end_time'] = TimeInterface::getMilliSecond();
        $context->monitor['time_diff'] = TimeInterface::timeDiff(
            $context->monitor['start_time'],$context->monitor['end_time']
        );
        $context = self::monitorTimeDiff($context);
        self::saveContext($context);
    }

    /**
     * 上下文从请求到结束的时间差
     * @param ContextInterface $context
     * @return ContextInterface
     */
    private static function monitorTimeDiff(ContextInterface $context)
    {
        $str = '';
        foreach ($context->monitor['time_diff']  as $K => $v){
            $str .= $v . ":";
        }
        $context->monitor['time_diff'] = rtrim($str,':');
        return $context;
    }


    /**
     * 保存请求体并计算从接收到结束的时间差，且异步执行
     * @param ContextInterface $context
     * @return bool
     */
    public static function saveContext(ContextInterface $context): bool
    {
        return true;
        var_dump($context);
        //
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

//    CREATE TABLE `monitor` (
//        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//        `monitor_uqid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//        `start_time` int(11) unsigned NOT NULL DEFAULT '0',
//        `request_method` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
//        `request_c` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
//        `request_a` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
//        `request_url` text COLLATE utf8_unicode_ci,
//        `request_ip` int(30) DEFAULT NULL,
//        `request_data` longtext COLLATE utf8_unicode_ci,
//        `end_time` int(11) unsigned DEFAULT '0',
//        `time_diff` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
//        PRIMARY KEY (`id`)
//    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
}