<?php

namespace handler\file;

use fize\cache\handler\file\FileCache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{

    public function test__construct()
    {
        $config = [
            'path' => __DIR__ . '/../temp',
        ];
        new FileCache($config);
        self::assertTrue(true);
    }
}
