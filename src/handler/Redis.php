<?php /** @noinspection PhpComposerExtensionStubsInspection */


namespace fize\cache\handler;


use fize\cache\CacheHandler;
use Redis as Driver;
use Exception;

/**
 * Redis形式缓存类
 * @package fize\cache\handler
 */
class Redis implements CacheHandler
{

    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var array 当前使用的配置
     */
    private $options = [
        'host'    => '127.0.0.1',
        'port'    => 6379,
        'timeout' => 0,
        'expire'  => 0
    ];

    /**
     * 构造函数
     * @param array $options 初始化默认选项
     * @throws Exception
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
        $this->driver = new Driver();
        $result = $this->driver->connect($this->options['host'], $this->options['port'], $this->options['timeout']);
        if (!$result) {
            throw new Exception($this->driver->getLastError());
        }
        if (isset($this->options['password'])) {
            $result = $this->driver->auth($this->options['password']);
            if (!$result) {
                throw new Exception($this->driver->getLastError());
            }
        }
        if (isset($this->options['dbindex'])) {
            $result = $this->driver->select($this->options['dbindex']);
            if (!$result) {
                throw new Exception($this->driver->getLastError());
            }
        }
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        $this->driver->close();
    }

    /**
     * 获取一个缓存
     * @param string $name 缓存名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get($name, $default = null)
    {
        $data = $this->driver->get($name);
        return $data ? $data : $default;
    }

    /**
     * 查看指定缓存是否存在
     * @param string $name 缓存名
     * @return bool
     */
    public function has($name)
    {
        return $this->driver->exists($name) > 0;
    }

    /**
     * 设置一个缓存
     * @param string $name 缓存名
     * @param mixed $value 缓存值
     * @param int $expire 有效时间，以秒为单位,0表示永久有效,不设置则使用当前配置
     * @throws Exception
     */
    public function set($name, $value, $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }
        if ($expire) {
            $result = $this->driver->set($name, $value, ['ex' => $expire]);
        } else {
            $result = $this->driver->set($name, $value);
        }
        if (!$result) {
            throw new Exception($this->driver->getLastError());
        }
    }

    /**
     * 删除一个缓存
     * @param string $name 缓存名
     * @throws Exception
     */
    public function remove($name)
    {
        $rst = $this->driver->del($name);
        if (!$rst) {
            throw new Exception($this->driver->getLastError());
        }
    }

    /**
     * 清空缓存
     * @throws Exception
     */
    public function clear()
    {
        $result = $this->driver->flushDB();
        if (!$result) {
            throw new Exception($this->driver->getLastError());
        }
    }
}
