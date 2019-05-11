<?php

namespace Modules\Order\Services;

use Modules\Order\Entities\Order;
use Modules\Order\Events\OrderWasCreatedEvent;
use Modules\Order\Events\OrderWasUpdatedEvent;
use Modules\Order\Events\OrderWasDeletedEvent;
use Modules\Order\Contracts\OrderServiceContract;
use Modules\Order\Dtos\CreateOrderData;
use Modules\Order\Dtos\UpdateOrderData;
use Modules\Order\Contracts\OrderRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

class OrderService implements OrderServiceContract
{
    /**
     * @var OrderRepositoryContract
     */
    protected $repository;

    /**
     * OrderService constructor.
     * @param $repository
     */
    public function __construct(OrderRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $user
     * @return Order[]
     */
    public function fromUser($user): Collection
    {
        if ($user instanceof User)
            $user = $user->id;
        return $this->repository->findByField('user_id', $user);
    }

    /**
     * @param CreateOrderData $data
     * @return Order
     */
    public function create(CreateOrderData $data, User $user): Order
    {
        $data->with('user_id', $user->id);
        $order = $this->repository->create($data->toArray());
        event(new OrderWasCreatedEvent($order));
        return $order;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $order = $this->repository->findOrResolve($id);
        $deleted = $this->repository->delete($order);
        if($deleted)
            event(new OrderWasDeletedEvent($order));
        return $deleted;
    }
}
