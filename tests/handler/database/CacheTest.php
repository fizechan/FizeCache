<?php

namespace handler\database;

use fize\cache\handler\database\Cache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{

    public function test__construct()
    {
        $config = [
            'db'    => [
                'type'   => 'mysql',
                'mode'   => 'pdo',
                'config' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'gm_test'
                ]
            ],
            'table' => 'sys_cache'
        ];
        new Cache($config);
        self::assertTrue(true);
    }
}
