<?php

namespace Modules\Order\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Order\Entities\Order;

class OrderTransformer extends Transformer
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
    public function transformResource(Order $order)
    {
        return [
            'id' => $order->id,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ];
    }
}
