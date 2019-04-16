<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.10.18
 * Time: 23:33.
 */

namespace Foundation\Traits;

use Foundation\Cache\ModelCache;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Trait Cacheable.
 *
 * @property int $cacheTime
 * @property array $secondaryCacheIndexes
 */
trait Cacheable
{
    private static $caching;

    public static function cache(): ModelCache
    {
        if (! isset(static::$caching)) {
            static::$caching = new ModelCache(static::class, get_class_property(static::class, 'secondaryCacheIndexes'), get_class_property(static::class, 'cacheTime'));
        }

        return static::$caching;
    }

    public static function find($id, $columns = ['*'])
    {
        if (static::cache()->enabled()) {
            $model = static::cache()->find($id) ?? static::recache($id);

            return static::filterFromColumns($model, $columns);
        }

        return static::findWithoutCache($id, $columns);
    }

    private static function recache($id)
    {
        $model = static::findWithoutCache($id);
        static::cache()->store($model);

        return $model;
    }

    public static function findWithoutCache($id, $columns = ['*'])
    {
        $model = new static();
        if (is_array($id) || $id instanceof Arrayable) {
            return $model::whereIn($model->getKeyName(), $id)->get($columns);
        }

        return $model::whereKey($id)->first($columns);
    }

    private static function filterFromColumns($model, $columns)
    {
        if ($model === null) {
            return;
        }

        if ($columns !== ['*']) {
            return collect($model)->first($columns);
        }

        return $model;
    }
}
