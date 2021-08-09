<?php /** @noinspection PhpComposerExtensionStubsInspection */

namespace fize\cache\handler\Memcache;

use fize\cache\CacheException;
use fize\cache\Item;
use fize\cache\PoolAbstract;
use Memcache;
use Psr\Cache\CacheItemInterface;

/**
 * 缓存池
 */
class Pool extends PoolAbstract
{

    /**
     * @var Memcache Memcache对象
     */
    protected $memcache;

    /**
     * 构造
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $default_config = [
            'servers' => [
                ['localhost', 11211, true, 100]
            ],
            'expires' => null
        ];
        $config = array_merge($default_config, $config);
        $this->config = $config;

        $this->memcache = new Memcache();
        foreach ($this->config['servers'] as $cfg) {
            $host = $cfg[0];
            $port = $cfg[1] ?? 11211;
            $persistent = $cfg[2] ?? true;
            $weight = $cfg[3] ?? 100;
            $result = $this->memcache->addServer($host, $port, $persistent, $weight);
            if (!$result) {
                throw new CacheException("Error in addServer $cfg[0].");
            }
        }
    }

    /**
     * 析构时关闭 Memcache 连接
     */
    public function __destruct()
    {
        $this->memcache->close();
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
        $value = $this->memcache->get($key);
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
    public function clear(): bool
    {
        return $this->memcache->flush();
    }

    /**
     * 从缓存池里移除缓存项
     * @param string $key 键名
     * @return bool
     */
    public function deleteItem($key): bool
    {
        if (!$this->hasItem($key)) {
            return true;
        }

        return $this->memcache->delete($key);
    }

    /**
     * 立刻为对象做数据持久化
     * @param CacheItemInterface $item 缓存对象
     * @return bool
     */
    public function save(CacheItemInterface $item): bool
    {
        $key = $item->getKey();
        $value = serialize($item->get());
        $expires = $item->getExpires();
        if (is_null($expires)) {
            $expires = $this->config['expires'];
        }
        return $this->memcache->set($key, $value, null, $expires);
    }
}
