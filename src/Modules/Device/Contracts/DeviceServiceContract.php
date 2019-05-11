<?php

namespace Modules\Device\Contracts;

use Modules\Device\Entities\Device;
use Modules\Device\Dtos\CreateDeviceData;
use Modules\Device\Dtos\UpdateDeviceData;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

interface DeviceServiceContract
{
    /**
     * @param $id
     * @param User $user
     * @return Device
     */
    public function find($id, User $user): ?Device;

    /**
     * @param $user
     * @return Device[]
     */
    public function fromUser($user): Collection;

    /**
     * @param $id
     * @param CreateDeviceData $data
     * @return Device
     */
    public function create(CreateDeviceData $data, User $user): Device;

    /**
     * @param $id
     * @param User $user
     * @param UpdateDeviceData $data
     * @return Device
     */
    public function update($id, User $user, UpdateDeviceData $data): Device;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
