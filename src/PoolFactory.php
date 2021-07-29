<?php

namespace fize\cache;

/**
 * 缓存池工厂
 */
class PoolFactory
{
    /**
     * 创建一个缓存池实例
     * @param string $handler 使用的实际接口名称
     * @param array  $config  配置
     * @return PoolInterface
     */
    public static function create(string $handler, array $config = []): PoolInterface
    {
        $class = '\\' . __NAMESPACE__ . '\\handler\\' . $handler . '\\Pool';
        return new $class($config);
    }
}
