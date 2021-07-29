<?php

namespace fize\cache\handler\File;

use fize\cache\CacheException;
use fize\cache\Item;
use fize\cache\PoolAbstract;
use fize\crypt\Base64;
use fize\io\Directory;
use fize\io\File;
use Psr\Cache\CacheItemInterface;

/**
 * 文件形式缓存池
 *
 * 指定缓存文件夹路径需要创建文件夹、读写的权限。
 */
class Pool extends PoolAbstract
{

    /**
     * 构造
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
     * 析构时删除过期项
     */
    public function __destruct()
    {
        $this->deleteExpiredItems();
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
        $base64_key = Base64::encode($key);
        $file = $this->config['path'] . "/" . strtolower(substr($base64_key, 0, 2)) . '/' . $base64_key . ".cache";
        if (File::exists($file)) {
            $fso = new File($file);
            $data = unserialize($fso->getContents());
            if (!$data || !array_key_exists('expires', $data) || !array_key_exists('value', $data)) {
                throw new CacheException("An error occurred while fetching the cache [$key]");
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
    public function clear(): bool
    {
        $this->saveDeferredItems = [];
        $dir = new Directory($this->config['path']);
        return $dir->clear();
    }

    /**
     * 从缓存池里移除缓存项
     * @param string $key 键名
     * @return bool
     */
    public function deleteItem($key): bool
    {
        self::checkKey($key);
        if (isset($this->saveDeferredItems[$key])) {
            unset($this->saveDeferredItems[$key]);
        }
        $base64_key = Base64::encode($key);
        $file = $this->config['path'] . "/" . strtolower(substr($base64_key, 0, 2)) . '/' . $base64_key . ".cache";
        if (!File::exists($file)) {
            return true;
        }
        $fso = new File($file);
        return $fso->delete();
    }

    /**
     * 立刻为对象做数据持久化
     * @param CacheItemInterface $item 缓存对象
     * @return bool
     */
    public function save(CacheItemInterface $item): bool
    {
        /**
         * @var Item $item
         */
        $base64_key = Base64::encode($item->getKey());
        $file = $this->config['path'] . "/" . strtolower(substr($base64_key, 0, 2)) . '/' . $base64_key . ".cache";
        $data = [
            'value'   => $item->get(),
            'expires' => $item->getExpires()
        ];

        $fso = new File($file, 'w');
        $result = $fso->putContents(serialize($data));
        return $result !== false;
    }

    /**
     * 删除过期项
     * @param string|null $path 指定缓存文件夹，null 表示默认设置
     */
    protected function deleteExpiredItems(string $path = null)
    {
        if (is_null($path)) {
            $path = $this->config['path'];
        }
        $dir = new Directory($path, true);
        $dir->open();
        $dir->read(function ($item) use ($path) {
            $full_path = $path . "/" . $item;

            if (Directory::exists($full_path)) {
                $this->deleteExpiredItems($full_path);
                return;
            }

            $pathinfo = pathinfo($full_path);
            if ($pathinfo['extension'] == 'cache') {
                $fso = new File($full_path);
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
