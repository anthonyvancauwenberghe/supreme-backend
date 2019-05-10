<?php

namespace Modules\Supreme\Listeners;

use Foundation\Abstracts\Listeners\Listener;
use Modules\Device\Entities\Device;
use Modules\Device\Entities\DeviceGroup;
use Modules\Supreme\Events\SupremeItemRestockedEvent;
use Modules\Wishlist\Entities\Wishlist;
use Modules\Wishlist\Notifications\WishListItemRestockedNotification;

class SendWishlistItemRestockedNotifications extends Listener
{
    /**
     * @param SupremeItemRestockedEvent $event
     */
    public function handle(SupremeItemRestockedEvent $event): void
    {
        $deviceGroup = new DeviceGroup();

        $wishlistItems = Wishlist::where('size_id', $event->item->sizeId)
            ->with('user')
            ->with('user.devices')
            ->get();

        foreach ($wishlistItems as $wishlistItem) {
            $user = $wishlistItem->user();
            if ($user !== null && !empty($user->devices))
                $deviceGroup->addDevices($user->devices);
        }

        $deviceGroup->getAllowedWishlistNotificationDevices()->notify(new WishListItemRestockedNotification($event->item));
    }

    /**
     * @param SupremeItemRestockedEvent $event
     * @param $exception
     */
    public function failed(SupremeItemRestockedEvent $event, $exception): void
    {

    }

}