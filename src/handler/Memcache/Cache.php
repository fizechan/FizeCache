<?php

namespace fize\cache\handler\Memcache;

use fize\cache\CacheAbstract;

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
