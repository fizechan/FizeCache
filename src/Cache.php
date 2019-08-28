<?php

namespace fize\cache;

/**
 * 缓存类
 * @package fize\cache
 */
class Cache
{
    /**
     * @var CacheHandler
     */
    private static $handler;

    /**
     * 取得单例
     * @param string $driver 使用的实际接口名称
     * @param array $options 配置项
     * @return CacheHandler
     */
    public static function getInstance($driver, array $options = [])
    {
        if (empty(self::$handler)) {
            $class = '\\' . __NAMESPACE__ . '\\handler\\' . $driver;
            self::$handler = new $class($options);
        }
        return self::$handler;
    }
}
