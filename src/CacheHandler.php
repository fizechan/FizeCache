<?php


namespace fize\cache;

/**
 * 缓存处理接口
 * @package fize\cache
 */
interface CacheHandler
{

    /**
     * 构造函数
     * @param array $options 初始化默认选项
     */
    public function __construct(array $options = []);

    /**
     * 获取一个缓存
     * @param string $name 缓存名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * 查看指定缓存是否存在
     * @param string $name 缓存名
     * @return bool
     */
    public function has($name);

    /**
     * 设置一个缓存
     * @param string $name 缓存名
     * @param mixed $value 缓存值
     * @param int $expire 有效时间，以秒为单位,0表示永久有效
     */
    public function set($name, $value, $expire = null);

    /**
     * 删除一个缓存
     * @param string $name 缓存名
     */
    public function remove($name);

    /**
     * 清空缓存
     */
    public function clear();
}
