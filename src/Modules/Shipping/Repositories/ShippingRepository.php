<?php

namespace Modules\Shipping\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\Shipping\Contracts\ShippingRepositoryContract;
use Modules\Shipping\Entities\Shipping;

class ShippingRepository extends Repository implements ShippingRepositoryContract
{
    protected $eloquent = Shipping::class;

    public function setPrimary($shipping): Shipping
    {
        $shipping = $this->findOrResolve($shipping);

        $this->updateWhere(['user_id' => $shipping->user_id], ["primary" => false]);

        return $this->update($shipping, ["primary" => true]);
    }
}
