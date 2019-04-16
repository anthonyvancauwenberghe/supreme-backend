<?php

namespace Modules\Creditcard\Events;

use Foundation\Abstracts\Events\Event;
use Modules\Creditcard\Entities\Creditcard;

class CreditcardWasUpdatedEvent extends Event
{

    /**
     * The listeners that will be fired when the event is dispatched.
     * @var array
     */
    public $listeners = [];

    /**
     * @var Creditcard
     */
    public $creditcard;

    /**
     * Create a new event instance.
     *
     */
    public function __construct(Creditcard $creditcard)
    {
        $this->creditcard = $creditcard;
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
