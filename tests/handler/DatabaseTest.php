<?php

namespace handler;

use fize\cache\handler\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
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

        $cache = new Database($config);
        $cache->set('name', '陈峰展');
        $name = $cache->get('name');
        self::assertEquals($name, '陈峰展');
    }

    public function testGet()
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

        $cache = new Database($config);
        $name = $cache->get('name');
        self::assertEquals($name, '陈峰展');
    }

    public function testHas()
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

        $cache = new Database($config);
        $rst1 = $cache->has('name');
        self::assertTrue($rst1);
        $rst2 = $cache->has('name_not_exists');
        self::assertFalse($rst2);
    }

    public function testClear()
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

        $cache = new Database($config);
        $cache->clear();
        self::assertTrue(true);
    }


    public function testSet()
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

        $cache = new Database($config);
        $cache->set('name2', '陈峰展2');
        $name = $cache->get('name2');
        self::assertEquals($name, '陈峰展2');
    }

    public function testRemove()
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

        $cache = new Database($config);
        $cache->remove('name2');
        self::assertTrue(true);
    }

    public function testInitMysql()
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
            'table' => 'cache'
        ];
        Database::initMysql($config);
        self::assertTrue(true);
    }
}
