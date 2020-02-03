<?php

namespace fize\cache;

use InvalidArgumentException as BaseException;
use Psr\Cache\InvalidArgumentException as BaseInterface;
use Psr\SimpleCache\InvalidArgumentException as SimpleBaseInterface;

/**
 * 参数异常
 */
class InvalidArgumentException extends BaseException implements BaseInterface, SimpleBaseInterface
{

}
