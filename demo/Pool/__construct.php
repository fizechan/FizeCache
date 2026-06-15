<?php
require_once "../../vendor/autoload.php";

use Fize\Cache\Pool;

//使用 Pool 静态方法前必须先 Pool 初始化

$handler = 'File';
$config = [
    'path' => __DIR__ . '/../temp',
];
new Pool($handler, $config);

//可以开始使用 Pool 静态方法
