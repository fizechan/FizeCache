<?php

namespace handler\Memcached;

use fize\cache\handler\Memcached\Cache;
use PHPUnit\Framework\TestCase;

class TestCache extends TestCase
{

    public function test__construct()
    {
        new Cache();
        self::assertTrue(true);
    }
}
