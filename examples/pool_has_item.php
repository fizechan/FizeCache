<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$handler = 'file';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

if (Pool::hasItem('cfz')) {
    $item = Pool::getItem('cfz');
    $hit = $item->isHit();  // true
    var_dump($item->get());
}