<?php


use fize\cache\Cache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{

    public function testSet()
    {
        $options = [
            'host'    => '192.168.56.102',
            'port'    => 6379,
            'timeout' => 0,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = Cache::getInstance('Redis', $options);

        $rst1 = $cache->set('cfz', '我想在里面填什么都可以', 100);
        var_dump($rst1);
        $cache1 = $cache->get('cfz');
        var_dump($cache1);

        $rst2 = $cache->set('cfz2', '我想在里面填什么都可以2');
        var_dump($rst2);
        $cache2 = $cache->get('cfz2');
        var_dump($cache2);
    }

    public function testGet()
    {
        $cache = Cache::getInstance('File');

        $cache->set('cfz', 'hello world!');

        $cache1 = $cache->get('cfz');
        var_dump($cache1);

        $cache2 = $cache->get('cfz2');
        var_dump($cache2);

        $cache->set('cfz2', 'hello world2!');

        $cache2 = $cache->get('cfz2');
        var_dump($cache2);
    }

    public function testRemove()
    {
        $options = [
            'host'    => '192.168.56.102',
            'port'    => 6379,
            'timeout' => 0,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = Cache::getInstance('Redis', $options);

        $cache->set('cfz', '我想在里面填什么都可以', 100);
        $cache->remove('cfz');
        $cache1 = $cache->get('cfz');
        var_dump($cache1);

        $cache->set('cfz2', '我想在里面填什么都可以2');
        $cache->remove('cfz2');
        $cache2 = $cache->get('cfz2');
        var_dump($cache2);
    }

    public function testClear()
    {
        $options = [
            'host'    => '192.168.56.102',
            'port'    => 6379,
            'timeout' => 0,
            'expire'  => 0,
            'dbindex' => 15
        ];
        $cache = Cache::getInstance('Redis', $options);

        $cache->clear();
    }
}
