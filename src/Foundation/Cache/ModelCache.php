<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.10.18
 * Time: 14:11.
 */

namespace Foundation\Cache;

use Cache;
use Foundation\Exceptions\Exception;
use Illuminate\Support\Facades\Redis;

class ModelCache
{
    protected $model;

    protected $cacheTime;

    /* Unique secondary indexes */
    protected $secondaryIndexes;

    /**
     * ModelCache constructor.
     */
    public function __construct(string $model, array $indexes = [], $cacheTime = null)
    {
        $this->model = $model;
        $this->secondaryIndexes = $indexes;
        $this->cacheTime = $cacheTime;
    }

    /**
     * @param $id
     * @param string $modelClass
     *
     * @return \Eloquent
     */
    public function find($id, $eagerLoad = true)
    {
        $model = Cache::get(self::getCacheName($id));

        if ($eagerLoad) {
            return $this->eagerLoadRelations($model);
        }

        return $model;
    }

    public function findBy(string $index, $key, $eagerLoad = true)
    {
        if (! in_array($index, $this->secondaryIndexes)) {
            throw new Exception('provided index does not exist as secondary index on the cache model');
        }
        $modelId = $this->findSecondaryIndex($index, $key);

        if ($modelId === null) {
            $model = ($this->model)::where($index, $key)->first();
            if ($model !== null) {
                $this->store($model);
            }

            return $model;
        }

        return $this->find($modelId, $eagerLoad);
    }

    protected function eagerLoadRelations($model)
    {
        if ($model !== null) {
            return $model::eagerLoadRelations([$model])[0];
        }
    }

    protected function findSecondaryIndex(string $index, $key)
    {
        return Cache::get($this->getCacheName($key, $index));
    }

    /**
     * @param string
     */
    public function getCacheName($id, string $index = 'id')
    {
        return config('model.cache_prefix').':'.strtolower(get_short_class_name($this->model)).':'.$index.':'.$id;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getCacheTime()
    {
        return $this->cacheTime ?? config('model.cache_time');
    }

    /**
     * @param \Eloquent $model
     */
    public function store($model)
    {
        Cache::put($this->getCacheName($model->getKey()), $model->newFromBuilder($model->getAttributes()), $this->getCacheTime());
        $this->storeSecondaryIndexReferences($model);
    }

    /**
     * @param string    $index
     * @param \Eloquent $model
     */
    protected function storeSecondaryIndexReferences($model)
    {
        foreach ($this->secondaryIndexes as $index) {
            $indexValue = $model->$index;
            if ($indexValue !== null) {
                Cache::put($this->getCacheName($indexValue, $index), $model->getKey(), $this->getCacheTime());
            }
        }
    }

    /**
     * @param $id
     * @param string $modelClass
     *
     * @return bool
     */
    public function remove($id)
    {
        return Cache::forget($this->getCacheName($id));
    }

    public static function clearAll()
    {
        $pattern = config('model.cache_prefix');
        self::deleteWithPrefix($pattern);
    }

    /**
     * @param $prefix
     *
     * @throws Exception
     */
    private static function deleteWithPrefix($prefix)
    {
        $redis = self::getCacheConnection();
        $keyPattern = Cache::getPrefix().$prefix.'*';
        $keys = $redis->keys($keyPattern);
        $redis->delete($keys);
    }

    /**
     * @throws Exception
     *
     * @return \Illuminate\Redis\Connections\Connection
     */
    private static function getCacheConnection()
    {
        if (config('cache.default') === 'redis') {
            return Redis::connection('cache');
        }

        throw new Exception('This action is only possible with redis as cache driver');
    }

    /**
     * @param $modelClass
     *
     * @throws Exception
     */
    public function clearModelCache()
    {
        $pattern = config('model.cache_prefix').':'.strtolower(get_short_class_name($this->model));
        self::deleteWithPrefix($pattern);
    }

    public function enabled(): bool
    {
        return (bool) config('model.caching');
    }
}
