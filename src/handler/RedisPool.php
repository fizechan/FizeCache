<?php

namespace fize\cache\handler;

use Redis;
use Psr\Cache\CacheItemInterface;
use fize\cache\CacheException;
use fize\cache\Item;
use fize\cache\PoolAbstract;

/**
 * Redis形式缓存池
 */
class RedisPool extends PoolAbstract
{

    /**
     * @var Redis Redis对象
     */
    private $redis;

    /**
     * 构造函数
     * @param array $config 初始化默认选项
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $default_config = [
            'host'    => '127.0.0.1',
            'port'    => 6379,
            'timeout' => 0,
            'expires' => null
        ];
        $this->config = array_merge($default_config, $config);
        $this->redis = new Redis();
        $result = $this->redis->connect($this->config['host'], $this->config['port'], $this->config['timeout']);
        if (!$result) {
            throw new CacheException($this->redis->getLastError());
        }
        if (isset($this->config['password'])) {
            $result = $this->redis->auth($this->config['password']);
            if (!$result) {
                throw new CacheException($this->redis->getLastError());
            }
        }
        if (isset($this->config['dbindex'])) {
            $result = $this->redis->select($this->config['dbindex']);
            if (!$result) {
                throw new CacheException($this->redis->getLastError());
            }
        }
        $this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
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
        $value = $this->redis->get($key);
        if ($value !== false) {
            $item->set($value);
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
        return $this->redis->flushDB();
    }

    /**
     * 从缓存池里移除缓存项
     * @param string $key 键名
     * @return bool
     */
    public function deleteItem($key)
    {
        $num = $this->redis->del($key);
        return $num !== false;
    }

    /**
     * 立刻为对象做数据持久化
     * @param CacheItemInterface $item 缓存对象
     * @return bool
     */
    public function save(CacheItemInterface $item)
    {
        $key = $item->getKey();
        $value = $item->get();
        $expires = $item->getExpires();
        if (is_null($expires)) {
            $expires = $this->config['expires'];
        }
        if ($expires) {
            $result = $this->redis->set($key, $value, ['ex' => $expires]);
        } else {
            $result = $this->redis->set($key, $value);
        }
        return $result;
    }
}
