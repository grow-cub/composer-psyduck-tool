<?php
/**
 * 防止重复提交
 */

namespace Psyduck\AntiShake;


use Psyduck\Encrypt\DispatchInterface;
use Psyduck\Unique\UniqueInterface;

class AntiShakeInterface{

    /**
     * 防止短时间二次提交-redis版本
     * @param $object
     * @param $uid
     * @return bool
     */
    public static function AntiShakeRedis($object,$uid = null): bool
    {
        if(!$uid) return false;
        $key = 'AntiShake-redis-uid-'.DispatchInterface::mishuEncrypt($uid);
        $value = UniqueInterface::hybridId();
        if($object->get($key)){
            return false;
        }
        else{
            $object->setex($key, 1, $value);
            return true;
        }
    }
}