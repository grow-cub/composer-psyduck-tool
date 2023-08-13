<?php
//composer dump-autoload

require_once "../vendor/autoload.php";


use Psyduck\DefVariable\DefVariableInterface;
use Psyduck\Monitor\MonitorInterface;
use Psyduck\Response\ResponseInterface;


MonitorInterface::createGuid();

// $data = array();
// $data['user_name'] = '1';
// $data['user_age'] = '18';
// $data['user_school'] = '美团';

//DefVariableInterface::snakeToHumpMiddleware(true);
//var_dump(DefVariableInterface::$snakeToHumpMiddleware);
//var_dump(ResponseInterface::success($data));

//use Psyduck\Jwt\JwtInterface;
//
//$payData = JwtInterface::buildPayload(1);
//echo JwtInterface::getToken($payData);
//JwtInterface::refreshToken(1);


//$str = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJqd3RfYWRtaW4iLCJpYXQiOjE2ODYzMjAwMTEsImV4cCI6MTY4NjMyMDAyMSwibmJmIjoxNjg2MzIwMDcxLCJzdWIiOjEsImp0aSI6ImJmZjkzNjYyYzgwYjIxYTZhNzM2MDEwNmE0NGM2NTNiIn0.g5AteRpm2GMQQ3bCPtbCxo5RBDbtnEB-Z1X5ifD2rTU';
//var_dump(JwtInterface::verifyToken($str));

use Psyduck\Header\HeaderInterface;

//$array = [1,1,2];
//HeaderInterface::dealAllowReferer($array);