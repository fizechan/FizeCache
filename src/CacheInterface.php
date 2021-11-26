<?php

namespace Fize\Cache;

use Psr\SimpleCache\CacheInterface as BaseInterface;

/**
 * 简易缓存接口
 *
 * 在 PSR 基础上又定义了一些相关接口
 */
interface CacheInterface extends BaseInterface
{
    /**
     * 构造函数
     * @param array $config 配置
     */
    public function __construct(array $config = []);
}
