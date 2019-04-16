<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 19:44.
 */

namespace Modules\User\Listeners;

use Foundation\Abstracts\Listeners\Listener;
use Modules\Authorization\Entities\Role;
use Modules\User\Events\UserRegisteredEvent;
use Modules\User\Notifications\WelcomeUserWebNotification;

class RegisteredUserListener extends Listener
{
    /**
     * @param UserRegisteredEvent $event
     */
    public function handle(UserRegisteredEvent $event): void
    {
        $event->user->notify(new WelcomeUserWebNotification($event->user));
        $event->user->syncRoles(Role::MEMBER);
    }

    /**
     * @param UserRegisteredEvent $event
     * @param $exception
     */
    public function failed(UserRegisteredEvent $event, $exception): void
    {
    }
}
