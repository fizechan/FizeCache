<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$handler = 'file';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$result = Pool::clear();
var_dump($result);