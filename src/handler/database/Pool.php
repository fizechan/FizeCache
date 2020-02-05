<?php


namespace fize\cache\handler\database;

use Psr\Cache\CacheItemInterface;
use fize\db\Db;
use fize\db\definition\Db as Driver;
use fize\cache\PoolAbstract;
use fize\cache\Item;


/**
 * 缓存池
 */
class Pool extends PoolAbstract
{

    /**
     * @var Driver 使用的数据库驱动类对象
     */
    protected $db;

    /**
     * 构造函数
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
        $db_mode = isset($config['db']['mode']) ? $config['db']['mode'] : null;
        $this->db = Db::connect($config['db']['type'], $config['db']['config'], $db_mode);
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
        $this->deleteExpiredItems();
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
        if($row) {
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
     * 初始化，如果尚未建立 cache 表，可以运行该方法来建立表
     *
     * 适用于mysql
     * @param array $config
     */
    public static function initMysql(array $config)
    {
        $sql = <<<EOF
CREATE TABLE `{$config['table']}`  (
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '键名',
  `value` blob NULL DEFAULT NULL COMMENT '数据',
  `expires` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有效时间，null表示永久有效。',
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '缓存' ROW_FORMAT = Dynamic
EOF;
        $mode = isset($config['db']['mode']) ? $config['db']['mode'] : null;
        Db::connect($config['db']['type'], $config['db']['config'], $mode)->query($sql);
    }
}
