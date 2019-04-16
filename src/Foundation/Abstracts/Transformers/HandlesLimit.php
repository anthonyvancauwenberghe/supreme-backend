<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 04.11.18
 * Time: 19:59.
 */

namespace Foundation\Abstracts\Transformers;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait IncludesRelations.
 */
trait HandlesLimit
{
    /**
     * @return int
     */
    protected function parseRequestLimitParameter()
    {
        $request = request();
        if (isset($request->limit) && is_numeric($request->limit)) {
            return (int) $request->limit;
        }

        return -1;
    }

    public function getLimitParameter() :int
    {
        $requestedLimit = $this->parseRequestLimitParameter();
        $maxLimit = $this->limit;

        if ($maxLimit === -1) {
            return $requestedLimit;
        } elseif ($requestedLimit > $maxLimit) {
            return $maxLimit;
        }

        return $requestedLimit;
    }

    private static function processLimit(Collection $resource)
    {
        $class = static::class;
        $limit = call_class_function($class, 'getLimitParameter');
        if ($limit === -1) {
            return $resource;
        }

        return $resource->take((int) $limit);
    }
}
