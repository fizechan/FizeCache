<?php


namespace fize\cache\handler\database;


use fize\cache\AbstractCache;


/**
 * 简易缓存
 */
class Cache extends AbstractCache
{

    /**
     * 构造函数
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->pool = new Pool($this->config);
    }
}