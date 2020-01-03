<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$handler = 'file';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$item = Pool::getItem('key');
$item->set('value to save');
$result = Pool::save($item);
var_dump($result);