<?php
require_once "../vendor/autoload.php";

use fize\cache\Pool;

$handler = 'File';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

$result = Pool::deleteItems(['cfz', 'lyp', 'unfound']);
var_dump($result);
