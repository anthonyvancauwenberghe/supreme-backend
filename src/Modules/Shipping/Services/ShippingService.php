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
use Modules\User\Entities\User;

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
     * @param User|string|int $id
     * @return Shipping[]
     */
    public function fromUser($user): Collection
    {
        if ($user instanceof User)
            $user = $user->id;
        return $this->repository->findByField('user_id', $user);
    }

    /**
     * @param $id
     * @param UpdateShippingData $data
     * @return Shipping
     */
    public function update($id, UpdateShippingData $data): Shipping
    {
        $shipping = $this->repository->findOrResolve($id);
        $data->except('primary');

        if ($updated = !empty($input = $data->toArray()))
            $shipping = $this->repository->update($id, $input);

        if ($data->exists('primary')) {
            if ($data->primary)
                $shipping = $this->repository->setPrimary($shipping);
            else
                $shipping = $this->repository->setPrimary($this->fromUser($shipping->user_id)->first());
            $updated = true;
        }

        if ($updated)
            event(new ShippingWasUpdatedEvent($shipping));

        return $shipping;
    }

    /**
     * @param CreateShippingData $data
     * @param User $user
     * @return Shipping
     */
    public function create(CreateShippingData $data, User $user): Shipping
    {
        $primary = $data->primary ?? false;

        $data
            ->with('user_id', $user->id)
            ->override('primary', false);

        $count = $this->fromUser($user)->count();

        $shipping = $this->repository->create($data->toArray());

        if ($count === 0 || $primary)
            $shipping = $this->setPrimary($shipping);

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
        if ($deleted) {
            event(new ShippingWasDeletedEvent($shipping));
            if ($shipping->primary) {
                $shipping = $this->fromUser($shipping->user_id)->first();
                if ($shipping !== null) {
                    $this->setPrimary($shipping);
                }
            }
        }
        return $deleted;
    }

    protected function setPrimary($shipping)
    {
        return $this->update($shipping, UpdateShippingData::make(["primary" => true]));
    }
}