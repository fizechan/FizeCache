<?php

namespace fize\cache;

use InvalidArgumentException as BaseException;
use Psr\Cache\InvalidArgumentException as BaseInterface;
use Psr\SimpleCache\InvalidArgumentException as BaseSimpleInterface;

/**
 * 参数异常
 *
 * 本异常包含简易缓存和常规缓存
 */
class InvalidArgumentException extends BaseException implements BaseInterface, BaseSimpleInterface
{

}
