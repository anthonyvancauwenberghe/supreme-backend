<?php


namespace Modules\Settings\Listeners;


use Foundation\Abstracts\Listeners\Listener;
use Modules\Settings\Contracts\SettingsServiceContract;
use Modules\Settings\Dtos\CreateSettingsData;
use Modules\User\Events\UserRegisteredEvent;

class CreateSettingsForNewlyRegisteredUser extends Listener
{
    protected $settings;

    /**
     * RegisteredUserListener constructor.
     * @param $settings
     */
    public function __construct(SettingsServiceContract $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param UserRegisteredEvent $event
     */
    public function handle(UserRegisteredEvent $event): void
    {
        $this->settings->create(new CreateSettingsData([]), $event->user);
    }

    /**
     * @param UserRegisteredEvent $event
     * @param $exception
     */
    public function failed(UserRegisteredEvent $event, $exception): void
    {
    }
}