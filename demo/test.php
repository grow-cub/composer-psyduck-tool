<?php
//composer dump-autoload

require_once "../vendor/autoload.php";

use Psyduck\Response\ResponseInterface;


$data = array();
$data['user_name'] = '1';
$data['user_age'] = '18';
$data['user_school'] = '美团';

var_dump(ResponseInterface::success($data));
