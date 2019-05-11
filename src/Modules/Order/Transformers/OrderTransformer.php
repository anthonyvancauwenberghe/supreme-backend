<?php

namespace Modules\Order\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Order\Entities\Order;
use Modules\User\Transformers\UserTransformer;

class OrderTransformer extends Transformer
{
    /**
     * Determines wich relations can be requested with the resource.
     *
     * @var array
     */
    public $available = [
        'user' => UserTransformer::class
    ];

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
            "item_id" => $order->item_id,
            "style_id" => $order->style_id,
            "size_id" => $order->size_id,
            "mobile_api" => $order->mobile_api,
            "recaptcha_bypass" => $order->recaptcha_bypass,
            "checkout_delay" => $order->checkout_delay,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ];
    }
}
