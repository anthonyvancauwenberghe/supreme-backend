<?php

namespace Modules\Settings\Events;

use Foundation\Abstracts\Events\Event;
use Modules\Settings\Entities\Settings;

class SettingsWasDeletedEvent extends Event
{

    /**
     * The listeners that will be fired when the event is dispatched.
     * @var array
     */
    public $listeners = [];

    /**
     * @var Settings
     */
    public $settings;

    /**
     * Create a new event instance.
     *
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
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
