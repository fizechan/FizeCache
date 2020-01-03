<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$handler = 'file';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$item3 = Pool::getItem('item3');
$item3->set('value3');

$item4 = Pool::getItem('item4');
$item4->set('value4');

$items = [$item3, $item4];
$result = Pool::saveItems($items);
var_dump($result);