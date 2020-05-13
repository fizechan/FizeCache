<?php

namespace handler;

use fize\cache\handler\MemcacheCache;
use PHPUnit\Framework\TestCase;

class TestMemcacheCache extends TestCase
{

    public function test__construct()
    {
        new MemcacheCache();
        self::assertTrue(true);
    }
}
