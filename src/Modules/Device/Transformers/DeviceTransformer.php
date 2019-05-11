<?php

namespace Modules\Device\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Device\Entities\Device;
use Modules\Device\Permissions\DevicePermission;

class DeviceTransformer extends Transformer
{
    /**
     * Transform the resource into an array.
     *
     * @throws Exception
     *
     * @return array
     */
    public function transformResource(Device $device)
    {
        return [
            'device_id' => $device->device_id,
            'device_type' => $device->device_type,
            'notify_restock' => $device->notify_restock,
            'notify_wishlist' => $device->notify_wishlist,
            'notify_drop' => $device->notify_drop,
            'created_at' => $device->created_at,
            'updated_at' => $device->updated_at
        ];
    }
}
