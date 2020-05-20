<?php

namespace handler\Memcached;

use fize\cache\handler\Memcached\Pool;
use PHPUnit\Framework\TestCase;


class TestPool extends TestCase
{

    public function test__construct()
    {
        new Pool();
        self::assertTrue(true);
    }

    public function test__destruct()
    {
        $pool = new Pool();
        unset($pool);
        self::assertTrue(true);
    }

    public function testGetItem()
    {
        $pool = new Pool();
        $item = $pool->getItem('cfz');
        var_dump($item);
        var_dump($item->get());
        self::assertInstanceOf('Psr\Cache\CacheItemInterface', $item);
    }

    public function testClear()
    {
        $pool = new Pool();
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testDeleteItem()
    {
        $pool = new Pool();
        $result = $pool->deleteItem('lyp');
        self::assertTrue($result);
        $result = $pool->deleteItem('unfound');
        self::assertTrue($result);
    }

    public function testSave()
    {
        $pool = new Pool();
        $item = $pool->getItem('cfz');
        $item->set(['name' => '陈峰展']);
        $item->expiresAfter(10000);
        $result = $pool->save($item);
        self::assertTrue($result);
    }
}
