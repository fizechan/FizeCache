<?php

namespace handler;

use fize\cache\handler\MemcachedPool;
use PHPUnit\Framework\TestCase;


class TestMemcachedPool extends TestCase
{

    public function test__construct()
    {
        new MemcachedPool();
        self::assertTrue(true);
    }

    public function test__destruct()
    {
        $pool = new MemcachedPool();
        unset($pool);
        self::assertTrue(true);
    }

    public function testGetItem()
    {
        $pool = new MemcachedPool();
        $item = $pool->getItem('cfz');
        var_dump($item);
        var_dump($item->get());
        self::assertInstanceOf('Psr\Cache\CacheItemInterface', $item);
    }

    public function testClear()
    {
        $pool = new MemcachedPool();
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testDeleteItem()
    {
        $pool = new MemcachedPool();
        $result = $pool->deleteItem('lyp');
        self::assertTrue($result);
        $result = $pool->deleteItem('unfound');
        self::assertTrue($result);
    }

    public function testSave()
    {
        $pool = new MemcachedPool();
        $item = $pool->getItem('cfz');
        $item->set(['name' => '陈峰展']);
        $item->expiresAfter(10000);
        $result = $pool->save($item);
        self::assertTrue($result);
    }
}
