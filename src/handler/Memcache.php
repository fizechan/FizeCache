<?php
/** @noinspection PhpComposerExtensionStubsInspection */


namespace fize\cache\handler;


use fize\cache\CacheHandler;
use Memcache as Driver;
use Exception;


/**
 * Memcache形式缓存类
 * 适用于PHP5.6及以下版本，需要Memcache扩展
 * @deprecated 官方已停止维护，不建议使用
 * @package fize\cache\handler
 */
class Memcache implements CacheHandler
{

    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var array 当前使用的配置
     */
    private $options = [
        'host'     => 'localhost',
        'port'     => 11211,
        'timeout'  => 1,
        'pconnect' => false,
        'debug'    => false,
        'expire'   => 0
    ];

    /**
     * 构造函数
     * @param array $options 初始化默认选项
     * @throws Exception
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
        //memcache_debug($this->_options['debug']);
        $this->driver = new Driver();
        if ($this->options['pconnect']) {
            $result = $this->driver->pconnect($this->options['host'], $this->options['port'], $this->options['timeout']);
        } else {
            $result = $this->driver->connect($this->options['host'], $this->options['port'], $this->options['timeout']);
        }
        if (!$result) {
            throw new Exception('Error connecting to Memcached server', -1);
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
        return $data === false ? $default : $data;
    }

    /**
     * 查看指定缓存是否存在
     * @param string $name 缓存名
     * @return bool
     */
    public function has($name)
    {
        return $this->get($name) !== false;
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
        if ($expire > 0) {
            $expire = time() + $expire;
        }
        $result = $this->driver->set($name, $value, false, $expire);
        if (!$result) {
            throw new Exception("Error setting cache {$name}", -1);
        }
    }

    /**
     * 删除一个缓存
     * @param string $name 缓存名
     * @throws Exception
     */
    public function remove($name)
    {
        $rst = $this->driver->delete($name);
        if ($rst === false) {
            throw new Exception("Error while delete cache {$name}", -1);
        }
    }

    /**
     * 清空缓存
     * @throws Exception
     */
    public function clear()
    {
        $result = $this->driver->flush();
        if (!$result) {
            throw new Exception('An error occurred when Memcache deleted all stored elements', -1);
        }
    }
}
