<?php

namespace Modules\Shipping\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Shipping\Entities\Shipping;

class ShippingTransformer extends Transformer
{

    /**
     * Determines wich relations can be requested with the resource.
     *
     * @var array
     */
    public $available = [];

    /**
     * Transform the resource into an array.
     *
     * @throws Exception
     *
     * @return array
     */
    public function transformResource(Shipping $shipping)
    {
        return [
            'id' => $shipping->id,
            'created_at' => $shipping->created_at,
            'updated_at' => $shipping->updated_at,
        ];
    }
}
