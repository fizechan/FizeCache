<?php

namespace Tests\Handler\Memcached;

use Fize\Cache\Handler\Memcached\Cache;
use PHPUnit\Framework\TestCase;

class TestCache extends TestCase
{

    public function test__construct()
    {
        new Cache();
        self::assertTrue(true);
    }
}
