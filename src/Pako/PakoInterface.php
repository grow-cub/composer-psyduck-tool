<?php

namespace Psyduck\Pako;

class PakoInterface
{
    /**
     * @Author 
     * @Description 后端PHP压缩+前端JS解压
     * $array = array(
        "title"       => "this is pako.defalte test",
        "author"      => "slongzhang@qq.com",
        "date"        => "2021-04-02",
        "content"       => "test echo string"
    );
     * @Date 2023/6/8 18:57:49
     * @param $data
     * @return string
     */
    public static function encrypt($data): string
    {
        return base64_encode(gzdeflate(json_encode($data,256), 9));
    }

    /**
     * 解密
     * @return false|string
     */
    /**
     * @Author 
     * @Description 前端JS压缩+后端PHP解压
     * $base64String = 'PYw7DoMwEESvYm0dLMei
     * ospVVrDBFo4X8KQJ4u5ZGqTRFPN5
     * ByGjCA2ElJszrbyon+TNBeIgDfQg/
     * iLpbqNWtM6/xHV+bZsf9WPlxLj+Mc
     * RnF/ouRMtGrZCKC2sEdxudfw=='
     * @Date 2023/6/8 18:59:21
     * @param $base64String
     * @return false|string
     */
    public static function decode($base64String)
    {
        return gzinflate(base64_decode(($base64String)));
    }
}