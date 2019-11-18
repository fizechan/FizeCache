<?php


namespace fize\cache\handler;

use fize\cache\CacheHandler;
use fize\db\Db;
use fize\db\definition\Db as Driver;

/**
 * 数据库形式缓存类
 */
class Database implements CacheHandler
{

    /**
     * @var array 配置
     */
    protected $config;

    /**
     * @var Driver 使用的数据库驱动类对象
     */
    protected $db;

    /**
     * 构造函数
     * @param array $config 初始化默认选项
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->db = Db::connect($config['db']);
    }

    /**
     * 获取一个缓存
     * @param string $name 缓存名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get($name, $default = null)
    {
        $row = $this->db->table($this->config['table'])->where(['name' => $name])->findOrNull(true);
        if (!$row) {
            return $default;
        }
        if ($row['expire'] != 0 && $row['expire'] < time()) {
            return $default;
        }
        return unserialize($row['value']);
    }

    /**
     * 查看指定缓存是否存在
     * @param string $name 缓存名
     * @return bool
     */
    public function has($name)
    {
        $row = $this->db->table($this->config['table'])->where(['name' => $name])->findOrNull(true);
        if (!$row) {
            return false;
        }
        if ($row['expire'] != 0 && $row['expire'] < time()) {
            return false;
        }
        return true;
    }

    /**
     * 设置一个缓存
     * @param string $name 缓存名
     * @param mixed $value 缓存值
     * @param int $expire 有效时间，以秒为单位,0表示永久有效,不设置则使用当前配置
     */
    public function set($name, $value, $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->config['expire'];
        }
        if ($expire > 0) {
            $expire = time() + $expire;
        }
        $this->db->table($this->config['table'])->where(['name' => $name])->delete();
        $data = [
            'name'   => $name,
            'value'  => serialize($value),
            'expire' => $expire
        ];
        $this->db->table($this->config['table'])->insert($data);
    }

    /**
     * 删除一个缓存
     * @param string $name 缓存名
     */
    public function remove($name)
    {
        $this->db->table($this->config['table'])->where(['name' => $name])->delete();
    }

    /**
     * 清空缓存
     */
    public function clear()
    {
        $this->db->table($this->config['table'])->delete();
    }
}