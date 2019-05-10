<?php


namespace Modules\Authorization\Listeners;

use Foundation\Abstracts\Listeners\Listener;
use Modules\User\Events\UserRegisteredEvent;

class AssignRoleToNewlyRegisteredUser extends Listener
{

    /**
     * @param UserRegisteredEvent $event
     */
    public function handle(UserRegisteredEvent $event): void
    {
        $event->user->syncRoles(config('role.default'));
    }

    /**
     * @param UserRegisteredEvent $event
     * @param $exception
     */
    public function failed(UserRegisteredEvent $event, $exception): void
    {
    }
}