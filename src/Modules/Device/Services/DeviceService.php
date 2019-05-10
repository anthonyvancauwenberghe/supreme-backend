<?php

namespace Modules\Device\Services;

use Modules\Device\Entities\Device;
use Modules\Device\Events\DeviceWasCreatedEvent;
use Modules\Device\Events\DeviceWasUpdatedEvent;
use Modules\Device\Events\DeviceWasDeletedEvent;
use Modules\Device\Contracts\DeviceServiceContract;
use Modules\Device\Dtos\CreateDeviceData;
use Modules\Device\Dtos\UpdateDeviceData;
use Modules\Device\Contracts\DeviceRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

class DeviceService implements DeviceServiceContract
{

    /**
     * @var DeviceRepositoryContract
     */
    protected $repository;

    /**
     * DeviceService constructor.
     * @param $repository
     */
    public function __construct(DeviceRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @param User $user
     * @return Device
     */
    public function find($id, User $user): Device
    {
        return $this->repository->findWhere([
            "device_id" => $id,
            "user_id" => $user->id
        ], $user)->first();
    }

    /**
     * @param $user
     * @return Device[]
     */
    public function fromUser($user): Collection
    {
        if ($user instanceof User)
            $user = $user->id;
        return $this->repository->findByField('user_id', $user)->get();
    }

    /**
     * @param $id
     * @param UpdateDeviceData $data
     * @return Device
     */
    public function update($id, User $user, UpdateDeviceData $data): Device
    {
        $device = $this->find($id, $user);
        $device->update($data->toArray());
        event(new DeviceWasUpdatedEvent($device));
        return $device;
    }

    /**
     * @param CreateDeviceData $data
     * @return Device
     */
    public function create(CreateDeviceData $data, User $user): Device
    {
        $data->with('user_id', $user->id);
        $device = $this->repository->create($data->toArray());
        event(new DeviceWasCreatedEvent($device));
        return $device;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $device = $this->repository->findOrResolve($id);
        $deleted = $this->repository->delete($device);
        if ($deleted)
            event(new DeviceWasDeletedEvent($device));
        return $deleted;
    }
}