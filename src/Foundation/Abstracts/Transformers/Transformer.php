<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 29.10.18
 * Time: 09:35.
 */

namespace Foundation\Abstracts\Transformers;

use Foundation\Contracts\Transformable;
use Foundation\Exceptions\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Transformer.
 *
 * @method  array  transformResource
 *
 */
abstract class Transformer extends JsonResource implements Transformable
{
    use IncludesRelations, HandlesLimit;

    public $include = [];

    public $available = [];

    public $limit = -1;

    public function __construct($resource, $relations = [])
    {
        if (! ($resource instanceof Model)) {
            throw new Exception('Object passed to the transformer resource method is not a eloquent model', 500);
        }
        $this->resource = $resource;
        $relations = is_array($relations) ? $relations : [];
        parent::__construct(self::loadRelations($resource, $relations));
    }

    public static function resource($model, array $relations = []): self
    {
        return new static($model, $relations);
    }

    public static function collection($resource, array $relations = [])
    {
        if (! ($resource instanceof \Traversable)) {
            throw new Exception('Object passed to the transformer collection method is not a collection', 500);
        }
        $resource = self::processLimit($resource);
        $resource = self::loadRelations($resource, $relations);

        return new AnonymousTransformerCollection($resource, static::class);
    }

    public function serialize()
    {
        return json_decode(json_encode($this->jsonSerialize()), true);
    }

    public function toArray($request)
    {
        if (! method_exists($this, 'transformResource')) {
            throw new \Exception('transformResource method not set on '.static::class, 500);
        }

        return array_merge($this->transformResource($this->resource), $this->includeRelations());
    }
}
