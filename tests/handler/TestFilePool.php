<?php

namespace handler;

use fize\cache\handler\FilePool;
use PHPUnit\Framework\TestCase;

class TestFilePool extends TestCase
{

    public function test__construct()
    {
        $config = [
            'path' => __DIR__ . '/../../temp',
        ];
        new FilePool($config);
        self::assertTrue(true);
    }

    public function testSave()
    {
        $config = [
            'path' => __DIR__ . '/../../temp',
        ];
        $pool = new FilePool($config);
        $item = $pool->getItem('cfz');
        $item->set(['name' => '陈峰展']);
        $item->expiresAfter(10000);
        $result = $pool->save($item);
        self::assertTrue($result);
    }

    public function testDeleteItem()
    {
        $config = [
            'path' => __DIR__ . '/../../temp',
        ];
        $pool = new FilePool($config);
        $result = $pool->deleteItem('lyp');
        self::assertTrue($result);
        $result = $pool->deleteItem('unfound');
        self::assertTrue($result);
    }

    public function testClear()
    {
        $config = [
            'path' => __DIR__ . '/../../temp',
        ];
        $pool = new FilePool($config);
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testGetItem()
    {
        $config = [
            'path' => __DIR__ . '/../../temp',
        ];
        $pool = new FilePool($config);
        $item = $pool->getItem('cfz');
        var_dump($item);
        self::assertInstanceOf('Psr\Cache\CacheItemInterface', $item);
    }
}
