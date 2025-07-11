<?php

namespace Tests;

use Fize\Cache\CacheFactory;
use Fize\Cache\CacheInterface;
use PHPUnit\Framework\TestCase;

class TestCacheFactory extends TestCase
{

    public function testCreate()
    {
        $cache = CacheFactory::create('File');
        var_dump($cache);
        self::assertInstanceOf(CacheInterface::class, $cache);
    }
}
