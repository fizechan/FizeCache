<?php


use fize\cache\Cache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
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
        new Cache('Redis', $config);
        self::assertTrue(true);
    }

    /**
     * @depends test__construct
     */
    public function testGet()
    {
        Cache::set('cfz', 'hello world!');

        $cache1 = Cache::get('cfz');
        var_dump($cache1);
        self::assertEquals($cache1, 'hello world!');
        
        Cache::remove('cfz2');
        $cache2 = Cache::get('cfz2');
        var_dump($cache2);
        self::assertNull($cache2);

        Cache::set('cfz2', 'hello world2!');

        $cache2 = Cache::get('cfz2');
        var_dump($cache2);
        self::assertEquals($cache2, 'hello world2!');
    }

    /**
     * @depends test__construct
     */
    public function testHas()
    {
        Cache::remove('cfz1');
        $has1 = Cache::has('cfz1');
        var_dump($has1);
        self::assertFalse($has1);

        Cache::set('cfz1', 'hello world2!');
        $has2 = Cache::has('cfz1');
        var_dump($has2);
        self::assertTrue($has2);
    }

    /**
     * @depends test__construct
     */
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

    /**
     * @depends test__construct
     */
    public function testRemove()
    {
        Cache::set('cfz', '我想在里面填什么都可以');
        Cache::remove('cfz');
        $cache1 = Cache::get('cfz');
        var_dump($cache1);
        self::assertNull($cache1);
    }

    /**
     * @depends test__construct
     */
    public function testClear()
    {
        Cache::clear();
        self::assertTrue(true);
    }

    public function testGetInstance()
    {
        $cache = Cache::getInstance('File');
        var_dump($cache);
        self::assertInstanceOf('fize\cache\CacheHandler', $cache);
    }
}
