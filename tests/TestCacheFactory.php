<?php


use fize\cache\CacheFactory;
use PHPUnit\Framework\TestCase;

class TestCacheFactory extends TestCase
{

    public function testCreate()
    {
        $cache = CacheFactory::create('File');
        var_dump($cache);
        self::assertInstanceOf('fize\cache\CacheInterface', $cache);
    }
}
