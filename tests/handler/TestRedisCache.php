<?php

namespace handler;

use fize\cache\handler\RedisCache;
use PHPUnit\Framework\TestCase;

class TestRedisCache extends TestCase
{

    public function test__construct()
    {
        $config = [
            'host'    => '127.0.0.1',
            'port'    => 6379,
            'timeout' => 10,
            'expires' => null,
            'dbindex' => 15
        ];
        new RedisCache($config);
        self::assertTrue(true);
    }
}
