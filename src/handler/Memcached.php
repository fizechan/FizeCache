<?php

namespace fize\cache\handler;

use fize\cache\CacheHandler;
use Memcached as Driver;
use Exception;


/**
 * Memcached形式缓存类
 * 仅适用于linux，需要Memcached扩展
 */
class Memcached implements CacheHandler
{
    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var array 当前使用的配置
     */
    private $_options = [
        'servers' => [
            ['localhost', 11211, 100]
        ],
        'timeout' => 1,
        'expire'  => 0
    ];

    /**
     * 构造函数
     * @param array $options 初始化默认选项
     * @throws Exception
     */
    public function __construct(array $options = [])
    {
        $this->_options = array_merge($this->_options, $options);
        $this->driver = new Driver();
        $result = $this->driver->addServers($this->_options['servers']);
        if(!$result){
            throw new Exception($this->driver->getResultMessage(),  $this->driver->getResultCode());
        }
    }

    /**
     * 析构函数
     * @throws Exception
     */
    public function __destruct()
    {
        $result = $this->driver->quit();
        if(!$result){
            throw new Exception($this->driver->getResultMessage(),  $this->driver->getResultCode());
        }
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
        if(is_null($expire)){
            $expire = $this->_options['expire'];
        }
        if($expire > 0){
            $expire = time() + $expire;
        }
        $result = $this->driver->set($name, $value, $expire);
        if (!$result) {
            throw new Exception($this->driver->getResultMessage(), $this->driver->getResultCode());
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
        if (!$rst) {
            throw new Exception($this->driver->getResultMessage(), $this->driver->getResultCode());
        }
    }

    /**
     * 清空缓存
     * @throws Exception
     */
    public function clear()
    {
        $result = $this->driver->flush();
        if(!$result){
            throw new Exception($this->driver->getResultMessage(),  $this->driver->getResultCode());
        }
    }
}
