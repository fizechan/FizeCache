<?php


namespace fize\cache\handler\file;

use Psr\Cache\CacheItemInterface;
use fize\crypt\Base64;
use fize\io\Directory;
use fize\io\File;
use fize\cache\PoolAbstract;
use fize\cache\CacheException;
use fize\cache\Item;


/**
 * 缓存池
 */
class Pool extends PoolAbstract
{

    /**
     * 构造函数
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $default_config = [
            'path'    => './data/cache',
            'expires' => null,
        ];
        $this->config = array_merge($default_config, $config);
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
        $file = $this->config['path'] . "/" . Base64::encode($key) . ".cache";
        if (File::exists($file)) {
            $fso = new File($file);
            $data = unserialize($fso->getContents());
            if (!$data || !array_key_exists('expires', $data) || !array_key_exists('value', $data)) {
                throw new CacheException("An error occurred while fetching the cache [{$key}]");
            }
            $item->set($data['value']);
            $item->expiresAt($data['expires']);
            if ($item->checkHit()) {
                $item->setHit(true);
            }
        }
        return $item;
    }

    /**
     * 清空缓存池
     * @return bool
     */
    public function clear()
    {
        $this->saveDeferredItems = [];
        $dir = new Directory($this->config['path'], true);
        return $dir->clear();
    }

    /**
     * 从缓存池里移除缓存项
     * @param string $key 键名
     * @return bool
     */
    public function deleteItem($key)
    {
        self::checkKey($key);
        if (isset($this->saveDeferredItems[$key])) {
            unset($this->saveDeferredItems[$key]);
        }
        $file = $this->config['path'] . "/" . Base64::encode($key) . ".cache";
        if (!File::exists($file)) {
            return true;
        }
        $fso = new File($file);
        $result = $fso->delete();
        $this->deleteExpiredItems();
        return $result;
    }

    /**
     * 立刻为对象做数据持久化
     * @param CacheItemInterface $item 缓存对象
     * @return bool
     */
    public function save(CacheItemInterface $item)
    {
        /**
         * @var Item $item
         */
        $file = $this->config['path'] . "/" . Base64::encode($item->getKey()) . ".cache";
        $data = [
            'value'   => $item->get(),
            'expires' => $item->getExpires()
        ];

        $fso = new File($file, 'w');
        $result = $fso->putContents(serialize($data));
        $fso->close();
        $this->deleteExpiredItems();
        return $result !== false;
    }

    /**
     * 删除过期项
     */
    protected function deleteExpiredItems()
    {
        $dir = new Directory($this->config['path'], true);
        $dir->open();
        $dir->read(function ($file) {
            $pathinfo = pathinfo($this->config['path'] . "/" . $file);
            if ($pathinfo['extension'] == 'cache') {
                $fso = new File($this->config['path'] . "/" . $file);
                $data = unserialize($fso->getContents());
                if (!$data || !array_key_exists('expires', $data) || !array_key_exists('value', $data)) {
                    $fso->delete();
                }
                if (!is_null($data['expires']) && $data['expires'] < time()) {
                    $fso->delete();
                }
            }
        }, true);
        $dir->close();
    }
}
