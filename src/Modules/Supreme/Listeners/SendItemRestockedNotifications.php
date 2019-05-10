<?php


namespace Modules\Supreme\Listeners;

use Foundation\Abstracts\Listeners\Listener;
use Modules\Device\Entities\Device;
use Modules\Device\Entities\DeviceGroup;
use Modules\Supreme\Events\SupremeItemRestockedEvent;
use Modules\Wishlist\Entities\Wishlist;
use Modules\Supreme\Notifications\ItemRestockedNotification;

class SendItemRestockedNotifications extends Listener
{
    /**
     * @param SupremeItemRestockedEvent $event
     */
    public function handle(SupremeItemRestockedEvent $event): void
    {

        $devices = new DeviceGroup(Device::all());
        $devices = $devices->getAllowedRestockNotificationDevices();
        $devices->notify(new ItemRestockedNotification($event->item));
    }

    /**
     * @param SupremeItemRestockedEvent $event
     * @param $exception
     */
    public function failed(SupremeItemRestockedEvent $event, $exception): void
    {
    }
}