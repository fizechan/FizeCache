<?php

namespace handler\database;

use fize\cache\handler\database\DatabasePool;
use PHPUnit\Framework\TestCase;

class PoolTest extends TestCase
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
        new DatabasePool($config);
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
            'table' => 't_cache'
        ];
        DatabasePool::initMysql($config);
        self::assertTrue(true);
    }

    public function testSave()
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
            'table' => 't_cache'
        ];
        $pool = new DatabasePool($config);
        $item = $pool->getItem('cfz');
        $item->set(['name' => '陈峰展']);
        $item->expiresAfter(10000);
        $result = $pool->save($item);
        self::assertTrue($result);
    }

    public function testDeleteItem()
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
            'table' => 't_cache'
        ];
        $pool = new DatabasePool($config);
        $result = $pool->deleteItem('lyp');
        self::assertTrue($result);
        $result = $pool->deleteItem('unfound');
        self::assertTrue($result);
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
            'table' => 't_cache'
        ];
        $pool = new DatabasePool($config);
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testGetItem()
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
            'table' => 't_cache'
        ];
        $pool = new DatabasePool($config);
        $item = $pool->getItem('cfz');
        var_dump($item);
        self::assertInstanceOf('Psr\Cache\CacheItemInterface', $item);
    }
}
