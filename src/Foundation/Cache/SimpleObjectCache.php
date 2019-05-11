<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.05.19
 * Time: 13:59
 */

namespace Foundation\Cache;


class SimpleObjectCache
{
    protected static $key;

    protected static $ttl;

    public static function get()
    {
        return \Cache::get(static::$key);
    }

    public static function put($value)
    {
        \Cache::put(static::$key, $value, static::$ttl);
    }
}
