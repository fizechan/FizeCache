<?php

namespace handler\Redis;

use fize\cache\handler\Redis\Cache;
use PHPUnit\Framework\TestCase;

class TestCache extends TestCase
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
        new Cache($config);
        self::assertTrue(true);
    }
}
