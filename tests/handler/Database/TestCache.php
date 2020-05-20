<?php

namespace handler\Database;

use fize\cache\handler\Database\Cache;
use PHPUnit\Framework\TestCase;

class TestCache extends TestCase
{

    public function test__construct()
    {
        $config = [
            'db'    => [
                'type'   => 'mysql',
                'mode'   => 'pdo',
                'config' => [
                    'host'     => '192.168.56.1',
                    'port'     => 3306,
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
