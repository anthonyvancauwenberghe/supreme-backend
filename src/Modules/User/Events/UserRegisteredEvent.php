<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 19:31.
 */

namespace Modules\User\Events;

use Foundation\Abstracts\Events\Event;
use Illuminate\Broadcasting\PrivateChannel;
use Modules\User\Entities\User;
use Modules\User\Listeners\RegisteredUserListener;

class UserRegisteredEvent extends Event
{
    public $listeners = [
        RegisteredUserListener::class,
    ];

    public $user;

    /**
     * UserRegisteredEvent constructor.
     *
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('app.'.$this->user->getKey());
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'user.registered';
    }
}
