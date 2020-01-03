<?php

namespace fize\cache;

use DateInterval;

/**
 * 简易缓存
 *
 * 遵循 PSR16 规范，使用静态方法调用
 */
class Cache
{
    /**
     * @var CacheInterface
     */
    private static $handler;

    /**
     * 常规调用请先初始化
     * @param string $handler 使用的实际接口名称
     * @param array $config 配置项
     */
    public function __construct($handler, array $config = [])
    {
        self::$handler = self::getInstance($handler, $config);
    }

    /**
     * 取得实例
     * @param string $handler 使用的实际接口名称
     * @param array $config 配置
     * @return CacheInterface
     */
    public static function getInstance($handler, array $config = [])
    {
        $class = '\\' . __NAMESPACE__ . '\\handler\\' . $handler . '\\Cache';
        return new $class($config);
    }

    /**
     * 获取一个缓存
     * @param string $key 键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return self::$handler->get($key, $default);
    }

    /**
     * 设置一个缓存
     * @param string $key 键名
     * @param mixed $value 值
     * @param DateInterval|int|null $ttl 以秒为单位的过期时长
     * @return bool
     */
    public static function set($key, $value, $ttl = null)
    {
        return self::$handler->set($key, $value, $ttl);
    }

    /**
     * 删除一个缓存
     * @param string $key 键名
     * @return bool
     */
    public static function delete($key)
    {
        return self::$handler->delete($key);
    }

    /**
     * 清空所有缓存
     * @return bool
     */
    public static function clear()
    {
        return self::$handler->clear();
    }

    /**
     * 获取多个缓存
     * @param iterable $keys 键名数组
     * @param mixed $default 默认值
     * @return iterable
     */
    public static function getMultiple($keys, $default = null)
    {
        return self::$handler->getMultiple($keys, $default);
    }

    /**
     * 设置多个缓存
     * @param iterable $values [键名=>值]数组
     * @param DateInterval|int|null $ttl 以秒为单位的过期时长
     * @return bool
     */
    public static function setMultiple($values, $ttl = null)
    {
        return self::$handler->setMultiple($values, $ttl);
    }

    /**
     * 删除多个缓存
     * @param iterable $keys 键名数组
     * @return bool
     */
    public static function deleteMultiple($keys)
    {
        return self::$handler->deleteMultiple($keys);
    }

    /**
     * 判断缓存是否存在
     * @param string $key 键名
     * @return bool
     */
    public static function has($key)
    {
        return self::$handler->has($key);
    }
}
