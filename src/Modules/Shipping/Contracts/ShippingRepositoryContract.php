<?php

namespace Modules\Shipping\Contracts;

use Larapie\Repository\Contracts\RepositoryInterface;
use Modules\Shipping\Entities\Shipping;

interface ShippingRepositoryContract extends RepositoryInterface
{
    public function setPrimary($shipping) :Shipping;
}
