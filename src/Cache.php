<?php

namespace Fize\Cache;

use DateInterval;

/**
 * 简易缓存
 *
 * 遵循 PSR16 规范，使用静态方法调用
 */
class Cache
{
    /**
     * @var CacheInterface 处理器
     */
    private static $handler;

    /**
     * 常规调用请先初始化
     * @param string $handler 使用的实际接口名称
     * @param array  $config  配置项
     */
    public function __construct(string $handler, array $config = [])
    {
        self::$handler = CacheFactory::create($handler, $config);
    }

    /**
     * 获取一个缓存
     * @param string $key     键名
     * @param mixed  $default 默认值
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return self::$handler->get($key, $default);
    }

    /**
     * 设置一个缓存
     * @param string                $key   键名
     * @param mixed                 $value 值
     * @param DateInterval|int|null $ttl   以秒为单位的过期时长
     * @return bool
     */
    public static function set(string $key, $value, $ttl = null): bool
    {
        return self::$handler->set($key, $value, $ttl);
    }

    /**
     * 删除一个缓存
     * @param string $key 键名
     * @return bool
     */
    public static function delete(string $key): bool
    {
        return self::$handler->delete($key);
    }

    /**
     * 清空所有缓存
     * @return bool
     */
    public static function clear(): bool
    {
        return self::$handler->clear();
    }

    /**
     * 获取多个缓存
     * @param iterable $keys    键名数组
     * @param mixed    $default 默认值
     * @return iterable
     */
    public static function getMultiple(iterable $keys, $default = null): iterable
    {
        return self::$handler->getMultiple($keys, $default);
    }

    /**
     * 设置多个缓存
     * @param iterable              $values [键名=>值]数组
     * @param DateInterval|int|null $ttl    以秒为单位的过期时长
     * @return bool
     */
    public static function setMultiple(iterable $values, $ttl = null): bool
    {
        return self::$handler->setMultiple($values, $ttl);
    }

    /**
     * 删除多个缓存
     * @param iterable $keys 键名数组
     * @return bool
     */
    public static function deleteMultiple(iterable $keys): bool
    {
        return self::$handler->deleteMultiple($keys);
    }

    /**
     * 判断缓存是否存在
     * @param string $key 键名
     * @return bool
     */
    public static function has(string $key): bool
    {
        return self::$handler->has($key);
    }
}
