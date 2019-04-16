<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 08.10.18
 * Time: 19:39.
 */

namespace Foundation\Exceptions;

class NotImplementedException extends \Exception
{
    protected $code = 500;
    protected $message = 'There is no implementation for this method yet';
}
