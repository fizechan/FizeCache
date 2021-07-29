<?php

namespace fize\cache;

use DateInterval;
use Traversable;

/**
 * 缓存抽象类
 */
abstract class CacheAbstract implements CacheInterface
{

    /**
     * @var array 配置
     */
    protected $config = [];

    /**
     * @var PoolInterface 缓存池
     */
    protected $pool;

    /**
     * 构造函数
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * 获取一个缓存
     * @param string $key     键名
     * @param mixed  $default 默认值
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $item = $this->pool->getItem($key);
        if ($item->isHit()) {
            return $item->get();
        }
        return $default;
    }

    /**
     * 设置一个缓存
     * @param string                $key   键名
     * @param mixed                 $value 值
     * @param DateInterval|int|null $ttl   以秒为单位的过期时长
     * @return bool
     */
    public function set($key, $value, $ttl = null): bool
    {
        $item = new Item($key);
        $item->set($value);
        $item->expiresAfter($ttl);
        return $this->pool->save($item);
    }

    /**
     * 删除一个缓存
     * @param string $key 键名
     * @return bool
     */
    public function delete($key): bool
    {
        return $this->pool->deleteItem($key);
    }

    /**
     * 清除所有缓存
     * @return bool
     */
    public function clear(): bool
    {
        return $this->pool->clear();
    }

    /**
     * 获取多个缓存
     * @param iterable $keys    键名数组
     * @param mixed    $default 默认值
     * @return iterable
     */
    public function getMultiple($keys, $default = null)
    {
        if ($keys instanceof Traversable) {
            $keys = iterator_to_array($keys);
        }
        $items = $this->pool->getItems($keys);
        $values = [];
        foreach ($items as $key => $item) {
            if ($item->isHit()) {
                $values[$key] = $item->get();
            } else {
                $values[$key] = $default;
            }
        }
        return $values;
    }

    /**
     * 设置多个缓存
     * @param iterable              $values [键名=>值]数组
     * @param DateInterval|int|null $ttl    以秒为单位的过期时长
     * @return bool
     */
    public function setMultiple($values, $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $result = $this->set($key, $value, $ttl);
            if ($result === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * 删除多个缓存
     * @param iterable $keys 键名数组
     * @return bool
     */
    public function deleteMultiple($keys): bool
    {
        if ($keys instanceof Traversable) {
            $keys = iterator_to_array($keys);
        }
        return $this->pool->deleteItems($keys);
    }

    /**
     * 判断缓存是否存在
     * @param string $key 键名
     * @return bool
     */
    public function has($key): bool
    {
        return $this->pool->hasItem($key);
    }
}
