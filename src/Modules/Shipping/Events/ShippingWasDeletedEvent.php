<?php

namespace Modules\Shipping\Events;

use Foundation\Abstracts\Events\Event;
use Modules\Shipping\Entities\Shipping;

class ShippingWasDeletedEvent extends Event
{

    /**
     * The listeners that will be fired when the event is dispatched.
     * @var array
     */
    public $listeners = [];

    /**
     * @var Shipping
     */
    public $shipping;

    /**
     * Create a new event instance.
     *
     */
    public function __construct(Shipping $shipping)
    {
        $this->shipping = $shipping;
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
