<?php

namespace Fize\Cache;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * 缓存池接口
 *
 * 在 PSR-6 基础上又定义了一些接口
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
    public function saveItems(array $items): bool;

    /**
     * GC。清除过期的缓存。
     */
    public function gc();
}
