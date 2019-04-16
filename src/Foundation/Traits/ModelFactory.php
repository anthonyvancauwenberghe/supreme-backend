<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 30.10.18
 * Time: 14:38.
 */

namespace Foundation\Traits;

use Illuminate\Database\Eloquent\FactoryBuilder;

trait ModelFactory
{
    public static function fromFactory(?int $amount = null) :FactoryBuilder
    {
        return factory(static::class, $amount);
    }
}
