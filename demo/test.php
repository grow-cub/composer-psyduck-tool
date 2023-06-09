<?php
//composer dump-autoload

require_once "../vendor/autoload.php";

use Psyduck\OrderNo\OrderNoInterface;

echo OrderNoInterface::getOrderNo();