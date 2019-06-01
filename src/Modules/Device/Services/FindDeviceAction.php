<?php


namespace Modules\Device\Services;


use Modules\Device\Contracts\DeviceRepositoryContract;
use Modules\Device\Entities\Device;

class FindDeviceAction extends Action
{
    /**
     * @var Device
     */
    public $device;

    public function handle(DeviceRepositoryContract $repository){
        return $repository->findWhere([
            "device_id" => $this->device->id,
            "user_id" => $this->user()->id
        ])->first();
    }
}