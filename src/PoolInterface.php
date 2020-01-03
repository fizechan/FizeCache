<?php


namespace fize\cache;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;


/**
 * 缓存池接口
 */
interface PoolInterface extends CacheItemPoolInterface
{
    /**
     * 构造
     * @param array $config 配置
     */
    public function __construct(array $config = []);

    /**
     * 设置多个缓存项
     * @param CacheItemInterface[] $items
     * @return bool
     */
    public function saveItems(array $items);
}