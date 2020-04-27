<?php

namespace fize\cache\handler;

use Memcached;
use Psr\Cache\CacheItemInterface;
use fize\cache\CacheException;
use fize\cache\Item;
use fize\cache\PoolAbstract;

/**
 * 缓存池
 */
class MemcachedPool extends PoolAbstract
{

    /**
     * @var Memcached Memcached对象
     */
    protected $memcached;

    /**
     * 构造
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $default_config = [
            'servers' => [
                ['localhost', 11211, 100]
            ],
            'timeout' => 10,
            'expires' => 0
        ];
        $config = array_merge($default_config, $config);
        $this->config = $config;

        $this->memcached = new Memcached();
        $result = $this->memcached->addServers($this->config['servers']);
        if (!$result) {
            throw new CacheException($this->memcached->getResultMessage(), $this->memcached->getResultCode());
        }
    }

    /**
     * 析构时关闭 Memcached 连接
     */
    public function __destruct()
    {
        $this->memcached->quit();
    }

    /**
     * 获取缓存项
     * @param string $key 键名
     * @return CacheItemInterface
     */
    public function getItem($key)
    {
        self::checkKey($key);
        if (isset($this->saveDeferredItems[$key])) {
            $item = $this->saveDeferredItems[$key];
            if ($item->checkHit()) {
                $item->setHit(true);
            }
            return $item;
        }

        $item = new Item($key);
        $value = $this->memcached->get($key);
        if ($value !== false) {
            $item->set(unserialize($value));
            $item->setHit(true);
        }
        return $item;
    }

    /**
     * 清空缓存池
     * @return bool
     */
    public function clear()
    {
        return $this->memcached->flush();
    }

    /**
     * 从缓存池里移除缓存项
     * @param string $key 键名
     * @return bool
     */
    public function deleteItem($key)
    {
        return $this->memcached->delete($key);
    }

    /**
     * 立刻为对象做数据持久化
     * @param CacheItemInterface $item 缓存对象
     * @return bool
     */
    public function save(CacheItemInterface $item)
    {
        $key = $item->getKey();
        $value = serialize($item->get());
        $expires = $item->getExpires();
        if (is_null($expires)) {
            $expires = $this->config['expires'];
        }
        if ($expires > 0) {
            $expires = time() + $expires;
        }
        return $this->memcached->set($key, $value, $expires);
    }
}
