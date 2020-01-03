<?php

namespace handler\file;

use fize\cache\handler\file\Cache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{

    public function test__construct()
    {
        $config = [
            'path' => __DIR__ . '/../temp',
        ];
        new Cache($config);
        self::assertTrue(true);
    }
}
