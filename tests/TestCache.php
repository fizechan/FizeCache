<?php

namespace Tests;

use Fize\Cache\Cache;
use PHPUnit\Framework\TestCase;

class TestCache extends TestCase
{

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $handler = 'File';
        new Cache($handler);
    }

    public function test__construct()
    {
        $handler = 'File';
        $config = [
            'path' => dirname(__DIR__) . '/data/cache',
        ];
        new Cache($handler, $config);
        self::assertTrue(true);
    }

    public function testGet()
    {
        $result = Cache::set('cfz', 'hello world!');
        self::assertTrue($result);

        $cache1 = Cache::get('cfz');
        var_dump($cache1);
        self::assertEquals('hello world!', $cache1);
    }

    public function testSet()
    {
        Cache::set('cfz', '我想在里面填什么都可以', 100);
        $cache1 = Cache::get('cfz');
        var_dump($cache1);
        self::assertEquals('我想在里面填什么都可以', $cache1);

        Cache::set('cfz2', '我想在里面填什么都可以2');
        $cache2 = Cache::get('cfz2');
        var_dump($cache2);
        self::assertEquals('我想在里面填什么都可以2', $cache2);
    }

    public function testDelete()
    {
        Cache::set('cfz', '我想在里面填什么都可以');
        Cache::delete('cfz');
        $cache1 = Cache::get('cfz');
        var_dump($cache1);
        self::assertNull($cache1);
    }

    public function testClear()
    {
        $result = Cache::clear();
        self::assertTrue($result);
    }

    public function testGetMultiple()
    {
        $values = Cache::getMultiple(['cfz', 'cfz2', 'cfz3'], '110');
        var_dump($values);
        self::assertEquals('我想在里面填什么都可以', $values['cfz']);
        self::assertEquals('我想在里面填什么都可以2', $values['cfz2']);
        self::assertEquals('110', $values['cfz3']);
        self::assertIsNotInt($values['cfz3']);
    }

    public function testSetMultiple()
    {
        $map = [
            'cfz5' => '我想在里面填什么都可以5',
            'cfz6' => [1, 2, 3, 4, '哈哈哈']
        ];
        $result = Cache::setMultiple($map);
        self::assertTrue($result);
    }

    public function testDeleteMultiple()
    {
        $keys = ['cfz1', 'cfz2', 'cfz3', 'cfz4', 'cfz5', 'cfz6'];
        $result = Cache::deleteMultiple($keys);
        self::assertTrue($result);
    }

    public function testHas()
    {
        Cache::delete('cfz1');
        $has1 = Cache::has('cfz1');
        var_dump($has1);
        self::assertFalse($has1);

        Cache::set('cfz1', 'hello world2!');
        $has2 = Cache::has('cfz1');
        var_dump($has2);
        self::assertTrue($has2);
    }

    public function testGc()
    {
        Cache::gc();
        self::assertTrue(true);
    }
}
