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
     * @return array
     * @throws Exception
     *
     */
    public function transformResource(Shipping $shipping)
    {
        return [
            "full_name" => $shipping->full_name,
            "first_name" => $shipping->first_name,
            "last_name" => $shipping->last_name,
            "email" => $shipping->email,
            "telephone" => $shipping->phoneNumber,
            "address" => $shipping->address,
            "address_2" => $shipping->address,
            "address_3" => $shipping->address,
            "city" => $shipping->city,
            "postal_code" => $shipping->postcode,
            "country" => $shipping->country,
            "primary" => $shipping->primary
        ];
    }
}
