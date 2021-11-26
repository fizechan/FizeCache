<?php

namespace Fize\Cache\Handler\Memcache;

use Fize\Cache\CacheAbstract;

/**
 * 简易缓存
 */
class Cache extends CacheAbstract
{

    /**
     * 构造
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->pool = new Pool($this->config);
    }
}
