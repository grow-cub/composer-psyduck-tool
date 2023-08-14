<?php

namespace Psyduck\Time;

class TimeInterface
{
    /**
     * @Author 
     * @Description 格式化时间戳
     * @Date 2022/9/19 22:32:58
     * @param $timestamp
     * @return false|string
     */
    public static function formatTimeStamp($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }

    /**
     * @Author 
     * @Description 获取时间戳
     * @Date 2022/9/19 22:29:56
     * @return int
     */
    public static function getTimeStamp(): int
    {
        return time();
    }

    /**
     * @Author 
     * @Description 获取毫秒级时间戳
     * @Date 2022/9/19 22:39:02
     * @return float
     */
    public static function getMilliSecond(): float
    {
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }

    /**
     * 计算两个时间戳之差
     * @param $begin_time
     * @param $end_time
     * @return array
     */
    public static function timeDiff( $begin_time, $end_time ): array
    {
        if ( $begin_time < $end_time ) {
            $starttime = $begin_time;
            $endtime = $end_time;
        } else {
            $starttime = $end_time;
            $endtime = $begin_time;
        }
        $timediff = $endtime - $starttime;
        $days = intval( $timediff / 86400 );
        $remain = $timediff % 86400;
        $hours = intval( $remain / 3600 );
        $remain = $remain % 3600;
        $mins = intval( $remain / 60 );
        $secs = $remain % 60;
        $res = array( "day" => $days, "hour" => $hours, "min" => $mins, "sec" => $secs );
        return $res;
    }
}