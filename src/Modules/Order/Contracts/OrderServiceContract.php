<?php

namespace Modules\Order\Contracts;

use Modules\Order\Entities\Order;
use Modules\Order\Dtos\CreateOrderData;
use Modules\Order\Dtos\UpdateOrderData;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

interface OrderServiceContract
{
    /**
     * @param $user
     * @return Order[]
     */
    public function fromUser($user): Collection;

    /**
     * @param $id
     * @param CreateOrderData $data
     * @return Order
     */
    public function create(CreateOrderData $data, User $user): Order;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
