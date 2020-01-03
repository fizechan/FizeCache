<?php
require_once "../vendor/autoload.php";

use fize\cache\Cache;

$cache = Cache::getInstance('file');

// 使用 cache 的实例方法进行操作

$cache->set('key', 'value');
$val = $cache->get('key');
var_dump($val);