<?php

namespace Modules\Device\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\Device\Contracts\DeviceRepositoryContract;
use Modules\Device\Entities\Device;

class DeviceRepository extends Repository implements DeviceRepositoryContract
{
    protected $eloquent = Device::class;
}
