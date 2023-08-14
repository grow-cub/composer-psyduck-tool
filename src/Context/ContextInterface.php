<?php

namespace Psyduck\Context;

use Psyduck\Monitor\MonitorInterface;
use Psyduck\Param\ParamInterface;

class ContextInterface
{
    /**
     * @var array
     */
    private $monitor;

    private $uid;

    public function __construct(){

    }

    /**
     * 获取上下文
     * @param $uid
     * @return ContextInterface
     */
    public static function getContext($uid = null)
    {
        $context = new ContextInterface();
        $requestData = null;
        if($_REQUEST){
            $requestData = ParamInterface::filterParams($_REQUEST);
        }
        $context->monitor = MonitorInterface::onStart($requestData);
        $context->uid = $uid;
        return $context;
    }
}