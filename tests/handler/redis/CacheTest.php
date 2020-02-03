<?php

namespace handler\redis;

use fize\cache\handler\redis\RedisCache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{

    public function test__construct()
    {
        $config = [
            'host'    => '192.168.56.101',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        new RedisCache($config);
        self::assertTrue(true);
    }
}
