<?php
require_once "../../vendor/autoload.php";

use Fize\Cache\Pool;

$handler = 'File';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$result = Pool::clear();
var_dump($result);
