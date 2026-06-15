<?php
require_once "../../vendor/autoload.php";

use Fize\Cache\Pool;

$handler = 'File';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$items = Pool::getItems(['key1', 'key2', 'key3']);
foreach ($items as $key => $item) {
    var_dump($key);
    var_dump($item->get());
}
