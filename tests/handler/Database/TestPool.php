<?php

namespace handler\Database;

use fize\cache\handler\Database\Pool;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;

class TestPool extends TestCase
{

    public function test__construct()
    {
        $config = [
            'database' => [
                'type'   => 'mysql',
                'mode'   => 'pdo',
                'config' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'gm_test'
                ]
            ],
            'table'    => 'sys_cache'
        ];
        new Pool($config);
        self::assertTrue(true);
    }

    public function testInitMysql()
    {
        $config = [
            'database' => [
                'type'   => 'mysql',
                'mode'   => 'pdo',
                'config' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'gm_test'
                ]
            ],
            'table'    => 't_cache2'
        ];
        Pool::init($config);
        self::assertTrue(true);
    }

    public function testSave()
    {
        $config = [
            'database' => [
                'type'   => 'mysql',
                'mode'   => 'pdo',
                'config' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'gm_test'
                ]
            ],
            'table'    => 't_cache'
        ];
        $pool = new Pool($config);
        $item = $pool->getItem('cfz');
        $item->set(['name' => '陈峰展']);
        $item->expiresAfter(10000);
        $result = $pool->save($item);
        self::assertTrue($result);
    }

    public function testDeleteItem()
    {
        $config = [
            'database' => [
                'type'   => 'mysql',
                'mode'   => 'pdo',
                'config' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'gm_test'
                ]
            ],
            'table'    => 't_cache'
        ];
        $pool = new Pool($config);
        $result = $pool->deleteItem('lyp');
        self::assertTrue($result);
        $result = $pool->deleteItem('unfound');
        self::assertTrue($result);
    }

    public function testClear()
    {
        $config = [
            'database' => [
                'type'   => 'mysql',
                'mode'   => 'pdo',
                'config' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'gm_test'
                ]
            ],
            'table'    => 't_cache'
        ];
        $pool = new Pool($config);
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testGetItem()
    {
        $config = [
            'database' => [
                'type'   => 'mysql',
                'mode'   => 'pdo',
                'config' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'gm_test'
                ]
            ],
            'table'    => 't_cache'
        ];
        $pool = new Pool($config);
        $item = $pool->getItem('cfz');
        var_dump($item);
        self::assertInstanceOf(CacheItemInterface::class, $item);
    }
}
