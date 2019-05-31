<?php

namespace Modules\Order\Events;

use Modules\Order\Listeners\SendOrderToDiscord;

class OrderWasSuccessfulEvent extends OrderWasCreatedEvent
{
    /**
     * The listeners that will be fired when the event is dispatched.
     * @var array
     */
    public $listeners = [
        SendOrderToDiscord::class
    ];
}
