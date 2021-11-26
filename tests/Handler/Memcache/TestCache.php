<?php

namespace Tests\Handler\Memcache;

use Fize\Cache\Handler\Memcache\Cache;
use PHPUnit\Framework\TestCase;

class TestCache extends TestCase
{

    public function test__construct()
    {
        new Cache();
        self::assertTrue(true);
    }
}
