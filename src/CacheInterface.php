<?php

namespace Fize\Cache;

use Psr\SimpleCache\CacheInterface as BaseInterface;

/**
 * 简易缓存接口
 *
 * 在 PSR-16 基础上又定义了一些接口
 */
interface CacheInterface extends BaseInterface
{
    /**
     * 构造函数
     * @param array $config 配置
     */
    public function __construct(array $config = []);

    /**
     * GC。清除过期的缓存。
     */
    public function gc();
}
