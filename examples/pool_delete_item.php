<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$handler = 'File';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$result = Pool::deleteItem('cfz');
var_dump($result);
