<?php

namespace Modules\Wishlist\Events;

use Foundation\Abstracts\Events\Event;
use Modules\Wishlist\Entities\Wishlist;

class WishlistWasUpdatedEvent extends Event
{

    /**
     * The listeners that will be fired when the event is dispatched.
     * @var array
     */
    public $listeners = [];

    /**
     * @var Wishlist
     */
    public $wishlist;

    /**
     * Create a new event instance.
     *
     */
    public function __construct(Wishlist $wishlist)
    {
        $this->wishlist = $wishlist;
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
