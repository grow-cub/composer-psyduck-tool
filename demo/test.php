<?php
//composer dump-autoload

require_once "../vendor/autoload.php";

use Psyduck\Rsa\RsaInterface;

echo RsaInterface::privateEncrypt(json_encode(array('1'=> 2)));
