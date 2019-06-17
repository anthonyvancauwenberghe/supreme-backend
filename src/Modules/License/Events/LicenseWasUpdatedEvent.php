<?php

namespace Modules\License\Events;

use Foundation\Abstracts\Events\Event;
use Modules\License\Entities\License;

class LicenseWasUpdatedEvent extends Event
{

    /**
     * The listeners that will be fired when the event is dispatched.
     * @var array
     */
    public $listeners = [];

    /**
     * @var License
     */
    public $license;

    /**
     * Create a new event instance.
     *
     */
    public function __construct(License $license)
    {
        $this->license = $license;
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
