<?php

namespace handler;

use fize\cache\handler\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{

    public function test__construct()
    {
        $config = [
            'path' => dirname(dirname(__DIR__)) . '/temp'
        ];

        $cache = new File($config);
        $cache->set('name', '陈峰展');
        $name = $cache->get('name');
        self::assertEquals($name, '陈峰展');
    }

    public function testGet()
    {
        $config = [
            'path' => dirname(dirname(__DIR__)) . '/temp'
        ];

        $cache = new File($config);
        $name = $cache->get('name');
        self::assertEquals($name, '陈峰展');
    }

    public function testHas()
    {
        $config = [
            'path' => dirname(dirname(__DIR__)) . '/temp'
        ];

        $cache = new File($config);
        $rst1 = $cache->has('name');
        self::assertTrue($rst1);
        $rst2 = $cache->has('name_not_exists');
        self::assertFalse($rst2);
    }

    public function testClear()
    {
        $config = [
            'path' => dirname(dirname(__DIR__)) . '/temp'
        ];

        $cache = new File($config);
        $cache->clear();
        self::assertTrue(true);
    }

    public function testSet()
    {
        $config = [
            'path' => dirname(dirname(__DIR__)) . '/temp'
        ];

        $cache = new File($config);
        $cache->set('name2', '陈峰展2');
        $name = $cache->get('name2');
        self::assertEquals($name, '陈峰展2');
    }

    public function testRemove()
    {
        $config = [
            'path' => dirname(dirname(__DIR__)) . '/temp'
        ];

        $cache = new File($config);
        $cache->remove('name2');
        self::assertTrue(true);
    }
}
