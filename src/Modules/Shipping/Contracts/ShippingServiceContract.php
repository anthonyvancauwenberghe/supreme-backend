<?php

namespace Modules\Shipping\Contracts;

use Modules\Shipping\Entities\Shipping;
use Illuminate\Database\Eloquent\Collection;
use Modules\Shipping\Dtos\CreateShippingData;
use Modules\Shipping\Dtos\UpdateShippingData;
use Modules\User\Entities\User;

interface ShippingServiceContract
{
    /**
     * @param $id
     * @return Shipping
     */
    public function find($id): Shipping;

    /**
     * @param $userId
     * @return Shipping[]
     */
    public function getByUserId($userId): Collection;

    /**
     * @param $id
     * @param CreateShippingData $data
     * @param User $user
     * @return Shipping
     */
    public function create(CreateShippingData $data, User $user): Shipping;

    /**
     * @param $id
     * @param UpdateShippingData $data
     * @return Shipping
     */
    public function update($id, UpdateShippingData $data): Shipping;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
