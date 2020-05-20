<?php

namespace handler\Memcache;

use fize\cache\handler\Memcache\Cache;
use PHPUnit\Framework\TestCase;

class TestCache extends TestCase
{

    public function test__construct()
    {
        new Cache();
        self::assertTrue(true);
    }
}
