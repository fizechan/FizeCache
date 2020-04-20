<?php

namespace handler;

use fize\cache\handler\FileCache;
use PHPUnit\Framework\TestCase;

class TestFileCache extends TestCase
{

    public function test__construct()
    {
        $config = [
            'path' => __DIR__ . '/../../temp',
        ];
        new FileCache($config);
        self::assertTrue(true);
    }
}
