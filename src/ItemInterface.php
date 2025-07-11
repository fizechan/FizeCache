<?php

namespace Fize\Cache;

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
     * @internal 禁止擅自初始化「Item」对象
     */
    public function __construct(string $key);

    /**
     * 设置是否命中
     *
     * @param bool $is_hit 是否命中
     * @internal 外部不应直接调用该方法
     */
    public function setHit(bool $is_hit);

    /**
     * 获取缓存项的过期时间戳
     * @return int|null 返回 null 表示永不过期
     * @internal 外部不应直接调用该方法
     */
    public function getExpires();

    /**
     * 根据设置判断缓存是否有效
     * @return bool
     * @internal 外部不应直接调用该方法
     */
    public function checkHit(): bool;
}
