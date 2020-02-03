<?php

namespace handler\redis;

use fize\cache\handler\redis\RedisPool;
use PHPUnit\Framework\TestCase;

class PoolTest extends TestCase
{

    public function test__construct()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        new RedisPool($config);
        self::assertTrue(true);
    }

    public function testSave()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        $pool = new RedisPool($config);
        $item = $pool->getItem('cfz');
        $item->set(['name' => '陈峰展']);
        $item->expiresAfter(10000);
        $result = $pool->save($item);
        self::assertTrue($result);
    }

    public function testDeleteItem()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        $pool = new RedisPool($config);
        $result = $pool->deleteItem('lyp');
        self::assertTrue($result);
        $result = $pool->deleteItem('unfound');
        self::assertTrue($result);
    }

    public function testClear()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        $pool = new RedisPool($config);
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testGetItem()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        $pool = new RedisPool($config);
        $item = $pool->getItem('cfz');
        var_dump($item);
        var_dump($item->get());
        print_r($item->get());
        self::assertInstanceOf('Psr\Cache\CacheItemInterface', $item);
    }
}
