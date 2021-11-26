<?php

namespace Tests\Handler\Redis;

use Fize\Cache\Handler\Redis\Pool;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;

class TestPool extends TestCase
{

    public function test__construct()
    {
        $config = [
            'host'    => '127.0.0.1',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        new Pool($config);
        self::assertTrue(true);
    }

    public function testSave()
    {
        $config = [
            'host'    => '127.0.0.1',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
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
            'host'    => '127.0.0.1',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
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
            'host'    => '127.0.0.1',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        $pool = new Pool($config);
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testGetItem()
    {
        $config = [
            'host'    => '127.0.0.1',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        $pool = new Pool($config);
        $item = $pool->getItem('cfz');
        var_dump($item);
        var_dump($item->get());
        print_r($item->get());
        self::assertInstanceOf(CacheItemInterface::class, $item);
    }
}
