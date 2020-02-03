<?php

namespace fize\cache;

use RuntimeException;
use Psr\Cache\CacheException as BaseInterface;
use Psr\SimpleCache\CacheException as SimpleBaseInterface;

/**
 * 缓存异常
 */
class CacheException extends RuntimeException implements BaseInterface, SimpleBaseInterface
{

}
