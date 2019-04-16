<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.10.18
 * Time: 13:31.
 */

namespace Foundation\Observers;

use Foundation\Abstracts\Observers\Observer;
use Foundation\Traits\Cacheable;

class CacheObserver extends Observer
{
    /**
     * @param Cacheable | \Eloquent $model
     */
    public function created($model)
    {
        $model::cache()->store($model);
    }

    /**
     * @param Cacheable | \Eloquent $model
     */
    public function updated($model)
    {
        $model::cache()->store($model);
    }

    /**
     * @param Cacheable | \Eloquent $model
     */
    public function deleted($model)
    {
        $model::cache()->remove($model->getKey());
    }
}
