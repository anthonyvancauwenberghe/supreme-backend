<?php

namespace Modules\Order\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\Order\Contracts\OrderRepositoryContract;
use Modules\Order\Entities\Order;

class OrderRepository extends Repository implements OrderRepositoryContract
{
    protected $eloquent = Order::class;
}
