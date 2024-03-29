<?php
require_once "../../vendor/autoload.php";

use Fize\Cache\Pool;

$handler = 'File';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

if (Pool::hasItem('cfz')) {
    $item = Pool::getItem('cfz');
    $hit = $item->isHit();  // true
    var_dump($item->get());
}
