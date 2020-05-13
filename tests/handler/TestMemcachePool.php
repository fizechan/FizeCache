<?php

namespace handler;

use fize\cache\handler\MemcachePool;
use PHPUnit\Framework\TestCase;


class TestMemcachePool extends TestCase
{

    public function test__construct()
    {
        new MemcachePool();
        self::assertTrue(true);
    }

    public function test__destruct()
    {
        $pool = new MemcachePool();
        unset($pool);
        self::assertTrue(true);
    }

    public function testGetItem()
    {
        $pool = new MemcachePool();
        $item = $pool->getItem('cfz');
        var_dump($item);
        var_dump($item->get());
        self::assertInstanceOf('Psr\Cache\CacheItemInterface', $item);
    }

    public function testClear()
    {
        $pool = new MemcachePool();
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testDeleteItem()
    {
        $pool = new MemcachePool();
        $result = $pool->deleteItem('lyp');
        self::assertTrue($result);
        $result = $pool->deleteItem('unfound');
        self::assertTrue($result);
    }

    public function testSave()
    {
        $pool = new MemcachePool();
        $item = $pool->getItem('cfz');
        $item->set(['name' => '陈峰展']);
        $item->expiresAfter(10000);
        $result = $pool->save($item);
        self::assertTrue($result);
    }
}
