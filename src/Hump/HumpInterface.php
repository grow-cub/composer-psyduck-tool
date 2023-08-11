<?php

namespace Psyduck\Hump;

class HumpInterface
{
    /**
     * @Author 
     * @Description 遍历数组 小驼峰转蛇形
     * @Date 2023/6/7 22:11:40
     * @param $arr
     * @return array
     */
    public static function ergodicArrayHumpToSnake($arr): array
    {
        $data = [];
        foreach($arr as $key => $val){
            if(is_array($val)){
                $val = self::ergodicArrayHumpToSnake($val);
            }
            $key = self::humpToSnake($key);
            $data[$key] = $val;
        }
        return $data;
    }

    /**
     * @Author 
     * @Description 小驼峰转蛇形
     * @Date 2023/6/7 22:12:14
     * @param $str
     * @return string
     */
    public static function humpToSnake($str): string
    {
        return strtolower(preg_replace('/(?<=[a-z]|[0-9])([A-Z])/', '_$1', $str));
    }

    /**
     * @Author 
     * @Description 遍历数组 蛇形转小驼峰
     * @Date 2023/6/7 22:12:35
     * @param $arr
     * @return array
     */
    public static function ergodicArraySnakeToHump($arr): array
    {
        $data = [];
        foreach($arr as $key => $val){
            if(is_array($val)){
                $val = self::ergodicArraySnakeToHump($val);
            }
            $key = self::snakeToHump($key);
            $data[$key] = $val;
        }
        return $data;
    }

    /**
     * @Author 
     * @Description 蛇形转小驼峰
     * @Date 2023/6/7 22:12:55
     * @param $str
     * @return array|string|string[]
     */
    public static function snakeToHump($str){
        return str_replace("_","",lcfirst(ucwords($str,"_")));
    }
}