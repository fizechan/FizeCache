<?php

namespace fize\cache\handler;

use fize\cache\CacheAbstract;

/**
 * 简易缓存
 */
class MemcachedCache extends CacheAbstract
{

    /**
     * 构造函数
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->pool = new MemcachedPool($this->config);
    }
}
