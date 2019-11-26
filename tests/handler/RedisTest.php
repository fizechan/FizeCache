<?php

namespace handler;

use fize\cache\handler\Redis;
use PHPUnit\Framework\TestCase;

class RedisTest extends TestCase
{

    public function test__construct()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = new Redis($config);

        $cache->set('cfz', '我想在里面填什么都可以', 100);
        $rst1 = $cache->get('cfz');
        var_dump($rst1);
        self::assertEquals($rst1, '我想在里面填什么都可以');

        $cache->set('cfz2', '我想在里面填什么都可以2');
        $rst2 = $cache->get('cfz2');
        var_dump($rst2);
        self::assertEquals($rst2, '我想在里面填什么都可以2');
    }

    public function testGet()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = new Redis($config);
        $cache->set('name', '陈峰展');
        $name = $cache->get('name');
        self::assertEquals($name, '陈峰展');
    }

    public function testHas()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = new Redis($config);
        $rst1 = $cache->has('name');
        self::assertTrue($rst1);
        $rst2 = $cache->has('name_not_exists');
        self::assertFalse($rst2);
    }

    public function testClear()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = new Redis($config);
        $cache->clear();
        self::assertTrue(true);
    }

    public function testSet()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = new Redis($config);
        $cache->set('name2', '陈峰展2');
        $name = $cache->get('name2');
        self::assertEquals($name, '陈峰展2');
    }

    public function testRemove()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = new Redis($config);
        $cache->remove('name2');
        self::assertTrue(true);
    }

    public function test__destruct()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = new Redis($config);
        unset($cache);
        self::assertTrue(true);
    }
}
