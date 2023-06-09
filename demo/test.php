<?php
//composer dump-autoload

require_once "../vendor/autoload.php";

use Psyduck\ApiSign\ApiSignInterface;

$data = array(
    'username' => 'abc@qq.com',
    'sex' => '1',
    'age' => '16',
    'addr' => 'guangzhou',
    'key' => '123',
    'timestamp' => time(),
);
//echo ApiSignInterface::getSign($data);

echo ApiSignInterface::verifySign($data);