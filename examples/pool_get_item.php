<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$handler = 'File';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$item = Pool::getItem('key');
$item->set('value to save');
Pool::save($item);
