<?php

namespace Tests\Handler\File;

use Fize\Cache\Handler\File\Cache;
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
