<?php


namespace fize\cache\handler;


use fize\cache\CacheHandler;
use fize\io\File as Driver;
use fize\io\Directory;
use fize\crypt\Base64;
use Exception;

/**
 * 文件形式缓存类
 * @package fize\cache\handler
 */
class File implements CacheHandler
{

    /**
     * @var array 当前使用的配置
     */
    private $options = [
        'path'   => './data/cache',
        'expire' => 0
    ];

    /**
     * 构造函数
     * @param array $options 初始化默认选项
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * 获取一个缓存
     * @param string $name 缓存名
     * @param mixed $default 默认值
     * @return mixed
     * @throws Exception
     */
    public function get($name, $default = null)
    {
        $file = $this->options['path'] . "/" . Base64::encode($name) . ".cache";
        if (!Driver::exists($file)) {
            //缓存尚未创建
            return $default;
        }
        $fso = new Driver($file);
        $data = unserialize($fso->getContents());
        if (!$data) {
            throw new Exception("An error occurred while fetching the cache [{$name}]");
        }
        if ($data['expire'] != 0 && $data['expire'] < time()) {  //缓存超时
            return $default;
        }
        return $data['data'];
    }

    /**
     * 查看指定缓存是否存在
     * @param string $name 缓存名
     * @return bool
     */
    public function has($name)
    {
        $file = $this->options['path'] . "/" . Base64::encode($name) . ".cache";
        if (!Driver::exists($file)) {
            return false;
        }
        $fso = new Driver($file);
        $data = unserialize($fso->getContents());
        if (!$data) {
            throw new Exception("An error occurred while fetching the cache [{$name}]");
        }

        if ($data['expire'] != 0 && $data['expire'] < time()) {  //缓存超时
            return false;
        }

        return true;
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
        $file = $this->options['path'] . "/" . Base64::encode($name) . ".cache";
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }
        if ($expire > 0) {
            $expire = time() + $expire;
        }

        //设置缓存
        $data = [
            'data'   => $value,
            'expire' => $expire
        ];

        $fso = new Driver($file, 'w');
        $result = $fso->putContents(serialize($data));
        if (!$result) {
            throw new Exception("An error occurred while set the cache [{$name}]");
        }
    }

    /**
     * 删除一个缓存
     * @param string $name 缓存名
     * @throws Exception
     */
    public function remove($name)
    {
        $file = $this->options['path'] . "/" . Base64::encode($name) . ".cache";
        $fso = new Driver($file);
        $rst = $fso->delete();
        if ($rst === false) {
            throw new Exception("An error occurred while delete the cache [{$name}]");
        }
    }

    /**
     * 清空缓存
     */
    public function clear()
    {
        $dir = new Directory($this->options['path'], true);
        $dir->clear();
    }
}
