<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$pool = Pool::getInstance('file');

// 使用 pool 的实例方法进行操作

$item = $pool->getItem('key');
$val = $item->get();
var_dump($val);