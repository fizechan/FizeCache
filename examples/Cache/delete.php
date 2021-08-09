<?php
require_once "../../vendor/autoload.php";

use fize\cache\Cache;

$config = [
    'host'    => '192.168.56.101',
    'port'    => 6379,
    'timeout' => 10,
    'expires' => null,
    'dbindex' => 15
];
new Cache('Redis', $config);

Cache::set('cfz', '我想在里面填什么都可以');
Cache::delete('cfz');
$cache1 = Cache::get('cfz');
var_dump($cache1);  //null
