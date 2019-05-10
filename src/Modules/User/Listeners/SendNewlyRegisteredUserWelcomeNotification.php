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
use Modules\Settings\Contracts\SettingsServiceContract;
use Modules\Settings\Dtos\CreateSettingsData;
use Modules\Settings\Services\SettingsService;
use Modules\User\Events\UserRegisteredEvent;
use Modules\User\Notifications\WelcomeUserWebNotification;

class SendNewlyRegisteredUserWelcomeNotification extends Listener
{
    /**
     * @param UserRegisteredEvent $event
     */
    public function handle(UserRegisteredEvent $event): void
    {
        $event->user->notify(new WelcomeUserWebNotification($event->user));
    }

    /**
     * @param UserRegisteredEvent $event
     * @param $exception
     */
    public function failed(UserRegisteredEvent $event, $exception): void
    {
    }
}
