<?php

namespace fize\cache;

use Psr\Cache\CacheItemInterface;

/**
 * 缓存项接口
 */
interface ItemInterface extends CacheItemInterface
{
    /**
     * 构造
     *
     *  禁止擅自初始化「CacheItemInterface」对象
     * 该类实例只能使用「CacheItemPoolInterface」对象的 getItem() 方法来获取
     * @param string $key 键名
     */
    public function __construct($key);

    /**
     * 设置是否命中
     *
     * 外部不应直接调用该方法
     * @param bool $is_hit 是否命中
     * @return $this
     */
    public function setHit($is_hit);

    /**
     * 获取缓存项的过期时间戳
     * @return int|null 返回 null 表示永不过期
     */
    public function getExpires();

    /**
     * 根据设置判断缓存是否有效
     * @return bool
     */
    public function checkHit();
}
