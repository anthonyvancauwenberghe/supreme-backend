<?php

namespace Modules\Device\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Device\Entities\Device;

class DeviceTransformer extends Transformer
{

    /**
     * Determines wich relations can be requested with the resource.
     *
     * @var array
     */
    public $available = [];

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
            'id' => $device->id,
            'created_at' => $device->created_at,
            'updated_at' => $device->updated_at,
        ];
    }
}
