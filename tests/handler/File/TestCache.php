<?php

namespace handler\File;

use fize\cache\handler\File\Cache;
use PHPUnit\Framework\TestCase;

class TestCache extends TestCase
{

    public function test__construct()
    {
        $config = [
            'path' => __DIR__ . '/../../../temp',
        ];
        new Cache($config);
        self::assertTrue(true);
    }
}
