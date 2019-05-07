<?php

namespace Modules\Supreme\Listeners;

use Foundation\Abstracts\Listeners\Listener;
use Modules\Supreme\Events\SupremeItemRestockedEvent;
use Modules\Wishlist\Entities\Wishlist;
use Modules\Wishlist\Notifications\WishListItemRestockedNotification;

class NotifyUsersWishlistItemRestocked extends Listener
{
    /**
     * @param SupremeItemRestockedEvent $event
     */
    public function handle(SupremeItemRestockedEvent $event): void
    {
        $wishlistItems = Wishlist::where('size_id', $event->item->sizeId)
            ->with('user')
            ->get();

        foreach ($wishlistItems as $wishlistItem) {
            $user = $wishlistItem->user();
            if ($user !== null && $user->wishlist_notifications)
                $user->notify(new WishListItemRestockedNotification($event->item));
        }
    }

    /**
     * @param SupremeItemRestockedEvent $event
     * @param $exception
     */
    public function failed(SupremeItemRestockedEvent $event, $exception): void
    {

    }

}