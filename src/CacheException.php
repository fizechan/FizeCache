<?php

namespace fize\cache;

use Psr\Cache\CacheException as BaseInterface;
use Psr\SimpleCache\CacheException as SimpleBaseInterface;
use RuntimeException;

/**
 * 缓存异常
 *
 * 本异常包含简易缓存及常规缓存
 */
class CacheException extends RuntimeException implements BaseInterface, SimpleBaseInterface
{

}
