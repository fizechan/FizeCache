<?php

namespace handler\File;

use fize\cache\handler\File\Pool;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;

class TestPool extends TestCase
{

    public function test__construct()
    {
        $config = [
            'path' => __DIR__ . '/../../../temp',
        ];
        new Pool($config);
        self::assertTrue(true);
    }

    public function testSave()
    {
        $config = [
            'path' => __DIR__ . '/../../../temp',
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
            'path' => __DIR__ . '/../../../temp',
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
            'path' => __DIR__ . '/../../../temp',
        ];
        $pool = new Pool($config);
        $result = $pool->clear();
        self::assertTrue($result);
    }

    public function testGetItem()
    {
        $config = [
            'path' => __DIR__ . '/../../../temp',
        ];
        $pool = new Pool($config);
        $item = $pool->getItem('cfz');
        var_dump($item);
        self::assertInstanceOf(CacheItemInterface::class, $item);
    }
}
