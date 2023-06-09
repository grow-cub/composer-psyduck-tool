<?php
//composer dump-autoload

require_once "../vendor/autoload.php";

use Psyduck\OrderSn\OrderSnInterface;

echo OrderSnInterface::getSn('13799324942');