<?php

namespace Modules\Shipping\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\Shipping\Contracts\ShippingRepositoryContract;
use Modules\Shipping\Entities\Shipping;

class ShippingRepository extends Repository implements ShippingRepositoryContract
{
    protected $eloquent = Shipping::class;
}
