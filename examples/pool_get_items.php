<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$handler = 'file';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$items = Pool::getItems(['key1', 'key2', 'key3']);
foreach ($items as $key => $item) {
    var_dump($key);
    var_dump($item->get());
}
Pool::save($item);