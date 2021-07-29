<?php

namespace fize\cache;

/**
 * 简易缓存工厂
 */
class CacheFactory
{
    /**
     * 创建一个简易缓存实例
     * @param string $handler 使用的实际接口名称
     * @param array  $config  配置
     * @return CacheInterface
     */
    public static function create(string $handler, array $config = []): CacheInterface
    {
        $class = '\\' . __NAMESPACE__ . '\\handler\\' . $handler . '\\Cache';
        return new $class($config);
    }
}
