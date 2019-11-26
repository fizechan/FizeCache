<?php
require_once "../vendor/autoload.php";

use fize\cache\Cache;

$config = [
    'host'    => '192.168.56.101',
    'port'    => 6379,
    'timeout' => 10,
    'expire'  => 0,
    'dbindex' => 15
];
new Cache('Redis', $config);

Cache::set('cfz', 'hello world!');
$cache1 = Cache::get('cfz');
var_dump($cache1);  //hello world!

Cache::remove('cfz2');
$cache2 = Cache::get('cfz2');
var_dump($cache2);  //null