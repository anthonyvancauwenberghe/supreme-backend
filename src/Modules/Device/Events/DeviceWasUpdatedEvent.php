<?php

namespace Modules\Device\Events;

use Foundation\Abstracts\Events\Event;
use Modules\Device\Entities\Device;

class DeviceWasUpdatedEvent extends Event
{

    /**
     * The listeners that will be fired when the event is dispatched.
     * @var array
     */
    public $listeners = [];

    /**
     * @var Device
     */
    public $device;

    /**
     * Create a new event instance.
     *
     */
    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
