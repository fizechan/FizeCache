<?php

namespace Fize\Cache;

use Psr\Cache\CacheItemInterface;

/**
 * 缓存池抽象类
 */
abstract class PoolAbstract implements PoolInterface
{
    /**
     * @var array 配置
     */
    protected $config = [];

    /**
     * @var Item[] 延后持久化的缓存项队列
     */
    protected $saveDeferredItems = [];

    /**
     * 构造
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * 检查是否有对应的缓存项
     * @param string $key 键名
     * @return bool
     */
    public function hasItem($key): bool
    {
        $item = $this->getItem($key);
        return $item->isHit();
    }

    /**
     * 返回一个可供遍历的缓存项集合
     * @param array $keys 键名组成的数组
     * @return CacheItemInterface[]
     */
    public function getItems(array $keys = []): array
    {
        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->getItem($key);
        }
        return $items;
    }

    /**
     * 移除多个缓存项
     * @param array $keys 键名组成的数组
     * @return bool
     */
    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            $result = $this->deleteItem($key);
            if ($result === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * 设置多个缓存项
     * @param CacheItemInterface[] $items
     * @return bool
     */
    public function saveItems(array $items): bool
    {
        foreach ($items as $item) {
            $result = $this->save($item);
            if ($result === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * 稍后为缓存项做数据持久化
     * @param CacheItemInterface $item
     * @return bool
     */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        $this->saveDeferredItems[$item->getKey()] = $item;
        return true;
    }

    /**
     * 提交所有的正在队列里等待的请求到数据持久层
     * @return bool
     */
    public function commit(): bool
    {
        foreach ($this->saveDeferredItems as $item) {
            $result = $this->save($item);
            if ($result === false) {
                return false;
            }
        }
        $this->saveDeferredItems = [];
        return true;
    }

    /**
     * GC。清除过期的缓存。
     */
    public function gc()
    {
    }

    /**
     * 检测键名是否符合要求
     * @param string $key 键名
     */
    protected static function checkKey(string $key)
    {
        $reserverd_words = ['{', '}', '(', ')', '/', '\\', '@', ':'];
        foreach ($reserverd_words as $reserverd_word) {
            if (strpos($key, $reserverd_word) !== false) {
                throw new InvalidArgumentException();
            }
        }
    }
}
