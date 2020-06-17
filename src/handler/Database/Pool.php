<?php

namespace fize\cache\handler\Database;

use RuntimeException;
use Psr\Cache\CacheItemInterface;
use fize\database\Db;
use fize\database\core\Db as Database;
use fize\cache\Item;
use fize\cache\PoolAbstract;

/**
 * 数据库形式缓存池
 */
class Pool extends PoolAbstract
{

    /**
     * @var Database 使用的数据库驱动类对象
     */
    protected $db;

    /**
     * 构造
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $default_config = [
            'table'   => 'cache',
            'expires' => null
        ];
        $config = array_merge($default_config, $config);
        $this->config = $config;
        $db_mode = isset($config['database']['mode']) ? $config['database']['mode'] : null;
        $this->db = Db::connect($config['database']['type'], $config['database']['config'], $db_mode);
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
        $row = $this->db->table($this->config['table'])->where(['key' => $key])->findOrNull(true);
        if ($row) {
            $item->set(unserialize($row['value']));
            $item->expiresAt($row['expires']);
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
        $this->db->table($this->config['table'])->delete();
        return true;
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
        $this->db->table($this->config['table'])->where(['key' => $key])->delete();
        return true;
    }

    /**
     * 立刻为对象做数据持久化
     * @param CacheItemInterface $item 缓存对象
     * @return bool
     */
    public function save(CacheItemInterface $item)
    {
        $data = [
            'key'     => $item->getKey(),
            'value'   => serialize($item->get()),
            'expires' => $item->getExpires()
        ];
        $row = $this->db->table($this->config['table'])->where(['key' => $data['key']])->findOrNull();
        if ($row) {
            unset($data['key']);
            $this->db->table($this->config['table'])->where(['key' => $row['key']])->update($data);
        } else {
            $this->db->table($this->config['table'])->insert($data);
        }
        return true;
    }

    /**
     * 删除过期项
     */
    protected function deleteExpiredItems()
    {
        $this->db->table($this->config['table'])->where(['expires' => ['<', time()]])->delete();
    }

    /**
     * 初始化表
     *
     * 如果尚未建立 cache 表，可以运行该方法来建立表
     * @param array $config 配置
     */
    public static function init(array $config)
    {
        switch ($config['database']['type']) {
            case 'mysql':
                $sql = <<<SQL
CREATE TABLE `{$config['table']}`  (
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '键名',
  `value` blob NULL DEFAULT NULL COMMENT '数据',
  `expires` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有效时间，null表示永久有效。',
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '缓存' ROW_FORMAT = Dynamic
SQL;
                break;
            default:
                throw new RuntimeException("暂不支持{$config['database']['type']}数据库驱动");
        }
        $mode = isset($config['database']['mode']) ? $config['database']['mode'] : null;
        Db::connect($config['database']['type'], $config['database']['config'], $mode)->query($sql);
    }
}
