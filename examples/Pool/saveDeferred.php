<?php
require_once "../../vendor/autoload.php";

use Fize\Cache\Pool;

$handler = 'File';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$item1 = Pool::getItem('item11');
$item1->set('value11');
$item1->expiresAfter(1000);

Pool::saveDeferred($item1);

$item = Pool::getItem('item11');
var_dump($item);
var_dump($item->isHit());  // true

$item2 = Pool::getItem('item22');
$item2->set('value22');
Pool::saveDeferred($item2);

// 未调用 Pool::commit() 方法前这些延迟缓存项都尚未持久化

$result = Pool::commit();
var_dump($result);
