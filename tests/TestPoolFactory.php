<?php


use fize\cache\PoolFactory;
use fize\cache\PoolInterface;
use PHPUnit\Framework\TestCase;

class TestPoolFactory extends TestCase
{

    public function testCreate()
    {
        $config = [
            'path' => __DIR__ . '/../temp',
        ];
        $pool = PoolFactory::create('File', $config);
        self::assertInstanceOf(PoolInterface::class, $pool);
    }
}
