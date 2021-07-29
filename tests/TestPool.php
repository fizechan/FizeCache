<?php


use fize\cache\Pool;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;

class TestPool extends TestCase
{

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $handler = 'File';
        $config = [
            'path' => __DIR__ . '/../temp',
        ];
        new Pool($handler, $config);
    }

    public function test__construct()
    {
        $handler = 'File';
        $config = [
            'path' => __DIR__ . '/../temp',
        ];
        new Pool($handler, $config);
        self::assertTrue(true);
    }

    public function testGetItem()
    {
        $item = Pool::getItem('cfz');
        var_dump($item);
        self::assertInstanceOf(CacheItemInterface::class, $item);
    }

    public function testGetItems()
    {
        $items = Pool::getItems(['cfz', 'lyp', 'unfound']);
        var_dump($items);
        self::assertIsIterable($items);
    }

    public function testHasItem()
    {
        $result = Pool::hasItem('lyp');
        self::assertTrue($result);
        $result = Pool::hasItem('unfound');
        self::assertFalse($result);
    }

    public function testClear()
    {
        $result = Pool::clear();
        self::assertTrue($result);
    }

    public function testDeleteItem()
    {
        $result = Pool::deleteItem('lyp');
        self::assertTrue($result);
        $result = Pool::deleteItem('unfound');
        self::assertTrue($result);
    }

    public function testDeleteItems()
    {
        $result = Pool::deleteItems(['cfz', 'lyp', 'unfound']);
        self::assertTrue($result);
    }

    public function testSave()
    {
        $item = Pool::getItem('lyp');
        $item->set('梁燕萍');
        $result = Pool::save($item);
        self::assertTrue($result);
    }

    public function testSaveDeferred()
    {
        $item1 = Pool::getItem('item1');
        $item1->set('value1');

        Pool::saveDeferred($item1);

        $item = Pool::getItem('item1');
        var_dump($item);
        self::assertTrue($item->isHit());
    }

    public function testCommit()
    {
        $item1 = Pool::getItem('item1');
        $item1->set('value1');
        $item1->expiresAfter(1000);

        Pool::saveDeferred($item1);

        $item = Pool::getItem('item1');
        var_dump($item);
        self::assertTrue($item->isHit());

        $item2 = Pool::getItem('item2');
        $item2->set('value2');
        Pool::saveDeferred($item2);

        $result = Pool::commit();
        self::assertTrue($result);
    }

    public function testSaveItems()
    {
        $item3 = Pool::getItem('item3');
        $item3->set('value3');

        $item4 = Pool::getItem('item4');
        $item4->set('value4');

        $items = [$item3, $item4];
        $result = Pool::saveItems($items);
        self::assertTrue($result);
    }
}
