<?php

namespace Modules\Shipping\Services;

use Modules\Shipping\Entities\Shipping;
use Modules\Shipping\Events\ShippingWasCreatedEvent;
use Modules\Shipping\Events\ShippingWasUpdatedEvent;
use Modules\Shipping\Events\ShippingWasDeletedEvent;
use Modules\Shipping\Contracts\ShippingServiceContract;
use Modules\Shipping\Dtos\CreateShippingData;
use Modules\Shipping\Dtos\UpdateShippingData;
use Modules\Shipping\Contracts\ShippingRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class ShippingService implements ShippingServiceContract
{

    /**
     * @var ShippingRepositoryContract
     */
    protected $repository;

    /**
     * ShippingService constructor.
     * @param $repository
     */
    public function __construct(ShippingRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return Shipping
     */
    public function find($id): Shipping
    {
        return $this->repository->findOrResolve($id);
    }

    /**
     * @param $id
     * @return Shipping[]
     */
    public function getByUserId($id): Collection
    {
        return $this->repository->findByField('user_id', $id)->get();
    }

    /**
     * @param $id
     * @param UpdateShippingData $data
     * @return Shipping
     */
    public function update($id, UpdateShippingData $data): Shipping
    {
        $shipping = $this->repository->update($id, $data->toArray());
        event(new ShippingWasUpdatedEvent($shipping));
        return $shipping;
    }

    /**
     * @param CreateShippingData $data
     * @return Shipping
     */
    public function create(CreateShippingData $data): Shipping
    {
        $shipping = $this->repository->create($data->toArray());
        event(new ShippingWasCreatedEvent($shipping));
        return $shipping;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $shipping = $this->repository->findOrResolve($id);
        $deleted = $this->repository->delete($shipping);
        if($deleted)
            event(new ShippingWasDeletedEvent($shipping));
        return $deleted;
    }
}