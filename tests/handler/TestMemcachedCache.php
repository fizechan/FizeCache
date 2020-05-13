<?php

namespace handler;

use fize\cache\handler\MemcachedCache;
use PHPUnit\Framework\TestCase;

class TestMemcachedCache extends TestCase
{

    public function test__construct()
    {
        new MemcachedCache();
        self::assertTrue(true);
    }
}
