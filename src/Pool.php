<?php

namespace Fize\Cache;

use Psr\Cache\CacheItemInterface;

/**
 * 缓存池
 *
 * 遵循 PSR-6 规范，使用静态方法调用
 */
class Pool
{

    /**
     * @var PoolInterface 处理器
     */
    private static $pool;

    /**
     * 常规调用请先初始化
     * @param string $handler 使用的实际接口名称
     * @param array  $config  配置项
     */
    public function __construct(string $handler, array $config = [])
    {
        self::$pool = PoolFactory::create($handler, $config);
    }

    /**
     * 获取缓存项
     * @param string $key 键名
     * @return CacheItemInterface
     */
    public static function getItem(string $key): CacheItemInterface
    {
        return self::$pool->getItem($key);
    }

    /**
     * 返回一个可供遍历的缓存项集合
     * @param array $keys 键名组成的数组
     * @return CacheItemInterface[]
     */
    public static function getItems(array $keys = []): array
    {
        return self::$pool->getItems($keys);
    }

    /**
     * 检查是否有对应的缓存项
     * @param string $key 键名
     * @return bool
     */
    public static function hasItem(string $key): bool
    {
        return self::$pool->hasItem($key);
    }

    /**
     * 清空缓存池
     * @return bool
     */
    public static function clear(): bool
    {
        return self::$pool->clear();
    }

    /**
     * 从缓存池里移除缓存项
     * @param string $key 键名
     * @return bool
     */
    public static function deleteItem(string $key): bool
    {
        return self::$pool->deleteItem($key);
    }

    /**
     * 移除多个缓存项
     * @param array $keys 键名组成的数组
     * @return bool
     */
    public static function deleteItems(array $keys): bool
    {
        return self::$pool->deleteItems($keys);
    }

    /**
     * 立刻为对象做数据持久化
     * @param CacheItemInterface $item 缓存对象
     * @return bool
     */
    public static function save(CacheItemInterface $item): bool
    {
        return self::$pool->save($item);
    }

    /**
     * 稍后为缓存项做数据持久化
     * @param CacheItemInterface $item
     * @return bool
     */
    public static function saveDeferred(CacheItemInterface $item): bool
    {
        return self::$pool->saveDeferred($item);
    }

    /**
     * 提交所有的正在队列里等待的请求到数据持久层
     * @return bool
     */
    public static function commit(): bool
    {
        return self::$pool->commit();
    }

    /**
     * 设置多个缓存项
     * @param CacheItemInterface[] $items
     * @return bool
     */
    public static function saveItems(array $items): bool
    {
        return self::$pool->saveItems($items);
    }

    /**
     * GC。清除过期的缓存。
     */
    public static function gc()
    {
        self::$pool->gc();
    }
}
