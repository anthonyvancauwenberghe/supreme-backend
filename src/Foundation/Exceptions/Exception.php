<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 08.10.18
 * Time: 19:39.
 */

namespace Foundation\Exceptions;

use Foundation\Abstracts\Exceptions\AbstractException;

class Exception extends AbstractException
{
    protected $code = 500;
}
