<?php

namespace fize\cache;

use DateInterval;
use DateTime;
use DateTimeInterface;

/**
 * 缓存项
 *
 * 该类实例只能使用「CacheItemPoolInterface」对象的 getItem() 方法来获取
 * @internal 禁止擅自初始化「Item」对象
 */
class Item implements ItemInterface
{

    /**
     * @var string 键名
     */
    protected $key;

    /**
     * @var bool 是否命中
     */
    protected $isHit = false;

    /**
     * @var mixed 缓存值
     */
    protected $value = null;

    /**
     * @var int|null 过期时间戳
     */
    protected $expires = null;

    /**
     * 构造
     * @param string $key 键名
     * @internal 禁止擅自初始化「Item」对象
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * 获取键名
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 是否命中
     * @return bool
     */
    public function isHit()
    {
        return $this->isHit;
    }

    /**
     * 获取值
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * 设置值
     * @param mixed $value 值
     * @return $this
     */
    public function set($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * 设置缓存项的准确过期时间点
     *
     * 参数 `$expiration`:
     *   为 null 表示使用默认设置
     * @param DateTimeInterface|null $expiration 过期时间点
     * @return $this
     */
    public function expiresAt($expiration)
    {
        if ($expiration instanceof DateTimeInterface) {
            $expiration = $expiration->getTimestamp();
        }
        $this->expires = $expiration;
        return $this;
    }

    /**
     * 设置缓存项的过期时间
     * @param DateInterval|int|null $time 以秒为单位的过期时长
     * @return $this
     */
    public function expiresAfter($time)
    {
        if ($time instanceof DateInterval) {
            $expires = (new DateTime())->add($time)->getTimestamp();
        } elseif (is_int($time)) {
            $expires = time() + $time;
        } else {
            $expires = $time;
        }
        $this->expires = $expires;
        return $this;
    }

    /**
     * 设置是否命中
     *
     * 外部不应直接调用该方法
     * @param bool $is_hit 是否命中
     * @return $this
     * @internal 外部不应直接调用该方法
     */
    public function setHit($is_hit)
    {
        $this->isHit = $is_hit;
        return $this;
    }

    /**
     * 获取缓存项的过期时间戳
     * @return int|null 返回 null 表示永不过期
     * @internal 外部不应直接调用该方法
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * 根据设置判断缓存是否有效
     * @return bool
     * @internal 外部不应直接调用该方法
     */
    public function checkHit()
    {
        if (is_null($this->expires)) {
            return true;
        }
        if ($this->expires < time()) {
            return false;
        }
        return true;
    }
}
