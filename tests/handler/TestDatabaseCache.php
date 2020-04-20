<?php

namespace handler;

use fize\cache\handler\DatabaseCache;
use PHPUnit\Framework\TestCase;

class TestDatabaseCache extends TestCase
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
        new DatabaseCache($config);
        self::assertTrue(true);
    }
}
