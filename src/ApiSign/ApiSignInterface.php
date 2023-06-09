<?php

namespace Psyduck\ApiSign;
use Psyduck\Time\TimeInterface;
use Psyduck\Response\ResponseInterface;

/**
 * 一般用于数据传输
 */
class ApiSignInterface
{
    // 设置一个公钥(key)和私钥(secret)，公钥用于区分用户，私钥加密数据，不能公开
    private static $key;
    private static $secret;

    public function __construct()
    {
        self::$key = 'c4ca4238a0b923820dcc509a6f75849b';
        self::$secret = '28c8edde3d61a0411511d3b1866f0636';
    }

    /**
     * @Author 可达鸭
     * @Description
     * $data = array(
        'username' => 'abc@qq.com',
        'sex' => '1',
        'age' => '16',
        'addr' => 'guangzhou',
        'key' => $key,
        'timestamp' => time(),
        );
     * @Date 2022/9/19 22:24:15
     * @param $data
     * @return string
     */
    public static function getSign($data): string
    {
        $data['timestamp'] = TimeInterface::getTimeStamp();
        return self::makeSign($data);

        // 发送的数据加上sign
        //$data['sign'] = getSign($secret, $data);
    }

    /**
     * @Author 可达鸭
     * @Description
     * @Date 2023/6/9 18:08:08
     * @param $data
     * @return void
     */
    public static function verifySign($data) {
        // 验证参数中是否有签名
        if (!isset($data['sign']) || !$data['sign']) {
            return ResponseInterface::fail('签名不存在');
        }
        if (!isset($data['timestamp']) || !$data['timestamp']) {
            return ResponseInterface::fail('参数不合法');
        }
        // 验证请求,5分钟失效
        if (time() - $data['timestamp'] > 300) {
            return ResponseInterface::fail('签名已过期');
        }
        $sign = $data['sign'];
        unset($data['sign']);
        $sign2 = self::makeSign($data);
        if ($sign != $sign2) {
            return ResponseInterface::fail('签名校验失败');
        }
    }

    /**
     * @Author 可达鸭
     * @Description
     * @Date 2023/6/9 18:13:10
     * @param $data
     * @return string
     */
    public static function makeSign($data){
        // 对数组的值按key排序
        ksort($data);
        // 生成url的形式
        $params = http_build_query($data);
        // 生成sign
        return md5($params . self::$secret);
    }
}