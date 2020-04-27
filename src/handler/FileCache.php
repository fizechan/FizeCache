<?php


namespace fize\cache\handler;

use fize\cache\CacheAbstract;


/**
 * 文件形式简易缓存
 */
class FileCache extends CacheAbstract
{

    /**
     * 构造
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->pool = new FilePool($this->config);
    }
}
