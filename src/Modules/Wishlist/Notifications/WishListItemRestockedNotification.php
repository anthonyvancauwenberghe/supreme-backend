<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 18:10.
 */

namespace Modules\Wishlist\Notifications;

use Illuminate\Notifications\Notification;
use Modules\Device\Abstracts\DeviceNotification;
use Modules\Supreme\Models\SupremeItem;

class WishListItemRestockedNotification extends DeviceNotification
{
    public $item;

    /**
     * WishListItemRestockedNotification constructor.
     * @param $item
     */
    public function __construct(SupremeItem $item)
    {
        $this->item = $item;
    }

    public function title(): string
    {
        return ucfirst($this->item->name) . " is back in stock!";
    }

    public function body(): string
    {
        return "The item has been placed in your cart to checkout.";
    }


}
